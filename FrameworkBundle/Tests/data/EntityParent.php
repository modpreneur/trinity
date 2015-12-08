<?php


namespace Trinity\FrameworkBundle\Tests\data;


class EntityParent
{
    protected $id;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function parentFunction(){
        return 'parent';
    }


    public function add($a, $b){
        return $a + $b;
    }

}