<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 13.2.16
 * Time: 12:13
 */

namespace Trinity\FrameworkBundle\Entity;


class BaseDynamoLog
{

    protected $dynamoKey;

    protected $created;

    /**
     * @return mixed
     */
    public function getDynamoKey()
    {
        return $this->dynamoKey;
    }

    /**
     * @param mixed $dynamoKey
     */
    public function setDynamoKey($dynamoKey)
    {
        $this->dynamoKey = $dynamoKey;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }





}