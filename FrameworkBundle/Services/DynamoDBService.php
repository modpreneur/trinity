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

class DynamoDBService
{


    /**
     * @var \Aws\DynamoDb\DynamoDbClient
     */
    private $connection;

    /**
     * @var array
     * Each log is represented by dynamoDB table that has MicroTime as main key.
     */

    private $logsList = ['exceptionLog', 'IPNLog', 'accessLog', 'userActionLog', 'notificationLog',
    'newsletterLog'];

    public function __construct($dynamoHost, $dynamoPort, $awsRegion, $awsKey, $awsSecret)
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


    public function writeInto($tableName,array $data){

        $this->connection->putItem([
            'TableName' => $tableName,
            'Item' => $data,
        ]);


    }

    private function createDynamoLogTable($name,$read=2,$write=2){
        $this->connection->createTable([
            'TableName' => $name,

            'AttributeDefinitions' => [
                [ 'AttributeName' => 'MicroTime', 'AttributeType' => 'S' ]
            ],
            'KeySchema' => [
                [ 'AttributeName' => 'MicroTime', 'KeyType' => 'HASH' ]
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


}
