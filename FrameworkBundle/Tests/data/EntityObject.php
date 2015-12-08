<?php


namespace Trinity\FrameworkBundle\Tests\data;


use Trinity\FrameworkBundle\Utils\ObjectMixin;


/**
 * Class EntityObject
 * @package Trinity\FrameworkBundle\Tests\data
 */
class EntityObject extends EntityParent
{

    /** @var string */
    private $name;

    /** @var string */
    private $price;

    /** @var string */
    private $desc;

    /** @var bool */
    private $active;


    /**
     * EntityObject constructor.
     */
    public function __construct()
    {
        $this->id = 11;

        $this->name = "Joe Dee";

        $this->price = 10;

        $this->desc = "Long text...";

        $this->active = true;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }


    /**
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }


    /**
     * @return string
     */
    public function getDesc()
    {
        return $this->desc;
    }


    /**
     * @param string $desc
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
    }


    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }


    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }


    public function test($a, $c){
        return $a + $c;
    }

}