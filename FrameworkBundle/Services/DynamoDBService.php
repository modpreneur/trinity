<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 12.2.16
 * Time: 10:59
 */
namespace Trinity\FrameworkBundle\Services;

use Aws\Sdk;
use Aws\DynamoDb\DynamoDbClient;
use Trinity\FrameworkBundle\Entity\BaseDynamoLog;

/**
    * @method string writeIntoExceptionLog(array $msg = [])
    * @method string writeIntoIPNLog(array $msg = [])
    * @method string writeIntoAccessLog(array $msg = [])
    * @method string writeIntoUserActionLog(array $msg = [])
    * @method string writeIntoNotificationLog(array $msg = [])
    * @method string writeIntoNewsletterLog(array $msg = [])
    */
class DynamoDBService
{
    /**
     * @var \Aws\DynamoDb\DynamoDbClient
     */
    private $connection;

    /**
     * @var array
     * Each log is represented by dynamoDB table that has MicroTime as main key.
     * For results managing class expanding BaseDynamoLog should exist for each
     */

    private $logsList = ['exceptionLog', 'IPNLog', 'accessLog', 'userActionLog', 'notificationLog',
    'newsletterLog'];

    public function __construct($dynamoHost=null, $dynamoPort=null, $awsRegion=null, $awsKey=null, $awsSecret=null)
    {
        $sdk = new Sdk([
            'region' => $awsRegion,
            'version' => 'latest',
            //'endpoint' => 'http://necktie_dynamoDB_1:8000',
            'endpoint' => "http://${dynamoHost}:${dynamoPort}",
            'credentials' => array(
                'key' => $awsKey,
                'secret' => $awsSecret
            ),
        ]);
        $this->connection = $sdk->createDynamoDb();
        $this->checkLogs();
    }

    /*
     * Ensure all tables exists
     */
        private function checkLogs(){
        $result = $this->connection->listTables();

        $existingTables = $result['TableNames'];

        foreach($this->logsList as $log){
            if(!in_array($log, $existingTables)){
                $this->createDynamoLogTable($log);
            }
        }
    }


    /**
     * @return DynamoDbClient
     */
    public function getConnection(){
        return $this->connection;
    }


    public function __call($name, array $args)
    {
        if (strpos($name, 'writeInto') === 0) {

            return $this->writeInto(
            //len('writeInto') = 9
                lcfirst(substr($name, 9)),
                isset($args[0]) ? $args[0] : []
            );
        }

        throw new \Exception("Error 500: Unsupported method called in DynamoDB Service");

    }


    protected function writeInto($tableName,array $data){

        $data ['created'] = [ 'S' => microtime() ] ;

        try {
            $response = $this->connection->putItem([
                'TableName' => $tableName,
                'Item' => $data,
            ]);
        }catch(Exception $e){
            dump($e);
        }
        return $data['created'];

    }

    private function createDynamoLogTable($name,$read=2,$write=2){
        $this->connection->createTable([
            'TableName' => $name,

                //created should be MicroTime()
            'AttributeDefinitions' => [
                [ 'AttributeName' => 'created', 'AttributeType' => 'S' ]
            ],
            'KeySchema' => [
                [ 'AttributeName' => 'created', 'KeyType' => 'HASH' ]
            ],
            'Projection' => [ // attributes to project into the index
                'ProjectionType' => 'ALL', // (ALL | KEYS_ONLY | INCLUDE)
            ],
            'ProvisionedThroughput' => [
                'ReadCapacityUnits'    => $read,
                'WriteCapacityUnits' => $write
            ]

        ]);
    }

    /**
     *
     * @param $entity
     * @param $item
     * @return array
     */
    public function decodeDynamoFormat(BaseDynamoLog $entity,$item){

        foreach($item as $key => $value)
        {
            $method = sprintf('set%s', ucwords($key)); // or you can cheat and omit ucwords() because PHP method calls are case insensitive
            // use the method as a variable variable to set your value
            $entity->$method(array_pop($value));

        }
            //fix date format, store key
        $entity->setDynamoKey($entity->getCreated());
        $entity->setCreated(explode(' ',$entity->getCreated())[1]);


        return $entity;
    }




}
