<?php

namespace Trinity\FrameworkBundle\DatabaseLogger;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Stores to database.
 */
class DatabaseHandler extends AbstractProcessingHandler
{
    /** @var  ContainerInterface */
    protected $_container;

    /**
     * @param int     $level  The minimum logging level at which this handler will be triggered
     * @param Boolean $bubble Whether the messages that are handled can bubble up the stack or not
     *
     * @internal param string $stream
     */
    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    /**
     * @param $container
     */
    public function setContainer($container)
    {
        $this->_container = $container;
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        if ('doctrine' == $record['channel']) {
            if ((int) $record['level'] >= Logger::WARNING) {
                error_log($record['message']);
            }

            return;
        }

        if ((int) $record['level'] >= Logger::ERROR) {
            $em = $this->_container->get('doctrine')->getManager();
            $conn = $em->getConnection();
            $conn->beginTransaction();

            try {
                $url = ($this->_container->get('request')->getUri());
                $ip = ($this->_container->get('request')->getClientIp());

                $token = $this->_container->get('security.token_storage')->getToken();
                $user = null;

                if ($token && $token->getUser() && !(is_string($token->getUser()))) {
                    $user = $token->getUser()->getId();
                }

                $created = date('Y-m-d H:i:s');
                $serverData = $record['extra']['serverData'];

                $conn->beginTransaction();
                $stmt = $conn->prepare(
                    'INSERT INTO system_log(log, level, serverData, modified, created, url, ip, user_id)
                                            VALUES ( ?, ?, ?, ?, ?, ?, ?, ? )
                                            RETURNING id;
                                           '
                );

                $stmt->bindValue(1, $conn->quote($record['message']));
                $stmt->bindValue(2, $record['level']);
                $stmt->bindValue(3, $conn->quote($serverData));
                $stmt->bindValue(4, $created);
                $stmt->bindValue(5, $created);
                $stmt->bindValue(6, $url);
                $stmt->bindValue(7, $ip);
                $stmt->bindValue(8, $user);

                $stmt->execute();
                $conn->commit();
                $row = $stmt->fetch();

                if (isset($record['context']['notification']) && isset($record['context']['notificationService'])) {
                    $notification = $record['context']['notification'];
                    $notificationService = $record['context']['notificationService'];

                    if (!is_object($notification) || !is_object($notificationService)) {
                        throw new \Exception('Service or entity is not valid object in DatabaseHandler');
                    }

                    if (!isset($row['id'])) {
                        throw new \Exception('No error id.');
                    }

                    $notificationService->pairLogWithEntity($row['id'], $notification);
                }

                $conn->commit();
            } catch (\Exception $e) {
                $conn->rollBack();

                // php logs
                error_log($record['message']);
                error_log($e->getMessage());
            }
        }
    }
}
