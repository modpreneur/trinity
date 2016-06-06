<?php
/*
 * This file is part of the Trinity project.
 */
namespace Trinity\FrameworkBundle\DatabaseLogger;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Trinity\Bundle\LoggerBundle\Services\ElasticLogService;
use Trinity\FrameworkBundle\Entity\ExceptionLog;

/**
 * Class DatabaseHandler.
 */
class DatabaseHandler extends AbstractProcessingHandler
{
    /** @var  TokenStorageInterface */
    private $tokenStorage;
    /** @var  Session */
    protected $session;
    /** @var RequestStack */
    private $requestStack;
    /** @var  ElasticLogService */
    private $esLogger;
    /**
     * @param Session $session
     * @param TokenStorageInterface $tokenStorage
     * @param RequestStack $requestStack
     * @param ElasticLogService $esLogger
     * @param $level = Logger::DEBUG
     * @param Boolean $bubble Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct(
        Session $session,
        TokenStorageInterface $tokenStorage,
        RequestStack $requestStack,
        ElasticLogService $esLogger,
        $level = Logger::DEBUG,
        $bubble = true
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
        $this->requestStack = $requestStack;
        $this->esLogger = $esLogger;
        parent::__construct($level, $bubble);
    }
    /**
     * @param array $record
     */
    protected function write(array $record)
    {
        $readable = '';
        if ('doctrine' === $record['channel']) {
            if ((int)$record['level'] >= Logger::WARNING) {
                error_log($record['message']);
            }
            return;
        }
        if ((int)$record['level'] >= Logger::ERROR) {
            //exception is logged twice, get rid of 'Uncaught...' version
            if (strpos($record['message'], 'Uncaught') === 0) {
                return;
            }
            $exception = new ExceptionLog();
            /** @var Request $request */
            $request = $this->requestStack->getCurrentRequest();
            $url = null;
            $ip = null;
            if ($request) {
                $url = $request->getUri();
                $ip = $request->getClientIp();
            } else {
                $requestedUrl = strpos($record['extra']['serverData'], 'REQUEST_URI:');
                $requestedUrl += strlen('REQUEST_URI: ');
                $endLine = strpos($record['extra']['serverData'], PHP_EOL, $requestedUrl);
                $url = substr($record['extra']['serverData'], $requestedUrl, $endLine-$requestedUrl);
                /*
                 * todo: get ip from extra too (which one?)
                 */
            }
            $token = $this->tokenStorage->getToken();
            $readable = $this->getReadable($record);
            $serverData = $record['extra']['serverData'];
            //sending into controller


                // notification part
//
//
//                $conn->commit();
//            } catch (\Exception $e) {
//
//                $conn->rollBack();
//
//                // php logs
//                error_log($record['message']);
//                error_log($e->getMessage());
//            }
            /*
             * Elastic part
             */
            //log, level, serverData, created, url, ip, user_id, readable
            $exception->setLog($record['message']);
            $exception->setLevel($record['level']);
            $exception->setServerData($serverData);
            $exception->setCreatedAt(time());
            $exception->setUrl($url);
            $exception->setIp($ip);
            if ($token && $token->getUser() && !is_string($token->getUser())) {
                $exception->setUser($token->getUser());
            }
            $exception->setReadable($readable);
            try {
                $this->esLogger->writeInto('ExceptionLog', $exception);
            } catch (\InvalidArgumentException $e) {
                //For others projects that may not have trinity logger bundle
                ///('Elastic logs are not enabled. Do you have trinity logger configured?');
            }
//            if (isset($record['context']['notification']) && isset($record['context']['notificationService'])) {
//                    $notification = $record['context']['notification'];
//                    $notificationService = $record['context']['notificationService'];
//
//                    if (!is_object($notification) || !is_object($notificationService)) {
//                        throw new \Exception('Service or entity is not valid object in DatabaseHandler');
//                    }
//
//                    if (!$exception->getId()) {
//                        dump($exception);
//                        die();
//                        throw new \Exception('No error id.');
//                    }
//
//                    $notificationService->pairLogWithEntity($exception->getId(), $notification);
//                }
        }
    }


    /**
     * @param array $e
     * @return string
     */
    private function getReadable($e)
    {
        /*
         * https://www-304.ibm.com/support/knowledgecenter/SSEPEK_10.0.0/com.ibm.db2z10.doc.codes/src/tpc/db2z_sqlstatevalues.dita
         * Known SQL codes
         */
        $sqlTag = 'PDOException';
        if (strncmp($e['message'], $sqlTag, strlen($sqlTag)) == 0) {
            /*
             * we got some DBALException
             */
            //dump($e);
            $line = strstr($e['message'], PHP_EOL, true);
            $short = substr($line, strpos($line, 'R: ') + 4);
            $readable =  ucfirst($short);
            if ($readable && $this->session->isStarted()) {
                $this->session->set('readable', $readable);
            }
            return $readable;
        }
        //readable format not supported yet
        return '';
    }
}
