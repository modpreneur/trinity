<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\DatabaseLogger;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Class DatabaseHandler.
 */
class DatabaseHandler extends AbstractProcessingHandler
{
    /** @var  ContainerInterface */
    protected $_container;


    /**
     * @param int $level The minimum logging level at which this handler will be triggered
     * @param Boolean $bubble Whether the messages that are handled can bubble up the stack or not
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
     * @param array $record
     */
    protected function write(array $record)
    {

        if ('doctrine' == $record['channel']) {
            if ((int)$record['level'] >= Logger::WARNING) {
                error_log($record['message']);
            }

            return;
        }

        if ((int)$record['level'] >= Logger::ERROR) {
            //exception is logged twice, get rid of 'Uncaught...' version
            if (strncmp($record['message'], 'Uncaught', 8) == 0) {
                return;
            };


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
                $readable = $this->getReadable($record);
                $created = date('Y-m-d H:i:s');
                $serverData = $record['extra']['serverData'];

                $conn->beginTransaction();
                $stmt = $conn->prepare(
                    'INSERT INTO exception_log(log, level, serverData, created, url, ip, user_id, readable)
                                            VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)
                                            RETURNING id;
                                           '
                );

                $stmt->bindValue(1, $conn->quote($record['message']));
                $stmt->bindValue(2, $record['level']);
                $stmt->bindValue(3, $conn->quote($serverData));
                $stmt->bindValue(4, $created);
                $stmt->bindValue(5, $url);
                $stmt->bindValue(6, $ip);
                $stmt->bindValue(7, $user);
                $stmt->bindValue(8, $readable);

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

    private function getReadable($e){
            /*
             * https://www-304.ibm.com/support/knowledgecenter/SSEPEK_10.0.0/com.ibm.db2z10.doc.codes/src/tpc/db2z_sqlstatevalues.dita
             * Known SQL codes
             */

        $SQLTag = "PDOException";
        if(strncmp($e['message'],$SQLTag,strlen($SQLTag))==0){
            /*
             * we got some DBALException
             */
            //dump($e);
            $line = strstr($e['message'],PHP_EOL,true);
            $short = substr($line,strpos($line,'R: ')+4);

            return ucfirst($short);

        }
            //readable format not supported yet
        return "";
    }
}
