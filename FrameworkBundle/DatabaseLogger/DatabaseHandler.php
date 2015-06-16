<?php

    namespace Trinity\FrameworkBundle\DatabaseLogger;


    use Monolog\Handler\AbstractProcessingHandler;
    use Monolog\Logger;
    use Symfony\Component\DependencyInjection\ContainerInterface;



    /**
     * Stores to database
     *
     */
    class DatabaseHandler extends AbstractProcessingHandler
    {
        /** @var  ContainerInterface */
        protected $_container;



        /**
         * @param int $level The minimum logging level at which this handler will be triggered
         * @param Boolean $bubble Whether the messages that are handled can bubble up the stack or not
         * @internal param string $stream
         */
        public function __construct($level = Logger::DEBUG, $bubble = true)
        {
            parent::__construct($level, $bubble);

        }



        /**
         *
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
            // Ensure the doctrine channel is ignored (unless its greater than a warning error), otherwise you will create an infinite loop, as doctrine like to log.. a lot..
            if ('doctrine' == $record['channel']) {

                if ((int)$record['level'] >= Logger::WARNING) {
                    error_log($record['message']);
                }

                return;
            }

            if ((int)$record['level'] == Logger::ERROR) {
                try {
                    $url = ($this->_container->get("request")->getUri());
                    $ip  = ($this->_container->get("request")->getClientIp());

                    $token = $this->_container->get("security.token_storage")->getToken();
                    $user  = NULL;

                    if($token && $token->getUser())
                        $user  = $token->getUser()->getId();

                    // Logs are inserted as separate SQL statements, separate to the current transactions that may exist within the entity manager.
                    $em = $this->_container->get('doctrine')->getEntityManager();
                    $conn = $em->getConnection();

                    $created = date('Y-m-d H:i:s');
                    $serverData = $record['extra']['serverData'];

                    $stmt = $conn->prepare(
                        'INSERT INTO System_log(log, level, serverData, modified, created, url, ip, user_id)
                         VALUES(' . $conn->quote($record['message']) . ', \'' . $record['level'] . '\', ' . $conn->quote($serverData) . ', \'' . $created . '\', \'' . $created . '\', \'' . $url .  '\' , \'' . $ip .  '\' , \'' . $user . '\');');
                    $stmt->execute();

                } catch (\Exception $e) {
                    // php logs
                    error_log($record['message']);
                    error_log($e->getMessage());
                }
            }
        }
    }