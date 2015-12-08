<?php


namespace Trinity\FrameworkBundle\Tests;


use Trinity\FrameworkBundle\Tests\data\EntityObject;
use Trinity\FrameworkBundle\Utils\ObjectMixin;


class UtilsObjectTest extends  \PHPUnit_Framework_TestCase
{

    public function testMixins(){
        $e = new EntityObject();

        $this->assertEquals('11', ObjectMixin::get($e, 'id'));
        $this->assertEquals('parent', ObjectMixin::get($e, 'parentFunction'));
        $this->assertEquals('parent', ObjectMixin::get($e, 'parentFunction()'));
        $this->assertEquals('parent', ObjectMixin::get($e, 'parentFunction'));
        $this->assertEquals('Joe Dee', ObjectMixin::get($e, 'name'));
        $this->assertEquals(10, ObjectMixin::get($e, 'add(4, 6)'));
    }


    /**
     *
     * @expectedException \Trinity\FrameworkBundle\Exception\MemberAccessException
     * @throws \Trinity\FrameworkBundle\Exception\MemberAccessException
     */
    public function testFunctionWithoutParams(){
        $e = new EntityObject();
        $this->assertEquals(10, ObjectMixin::get($e, 'add()'));
    }


    /**
     * @expectedException \Trinity\FrameworkBundle\Exception\MemberAccessException
     * @expectedExceptionMessage Cannot read an undeclared property Trinity\FrameworkBundle\Tests\data\EntityObject::$names or method Trinity\FrameworkBundle\Tests\data\EntityObject::names(), did you mean name?
     * @throws \Trinity\FrameworkBundle\Exception\MemberAccessException
     */
    public function testHing(){
        $e = new EntityObject();
        $this->assertEquals(10, ObjectMixin::get($e, 'names'));
    }


    /**
     * @expectedException \Trinity\FrameworkBundle\Exception\MemberAccessException
     * @expectedExceptionMessage Cannot read an undeclared property Trinity\FrameworkBundle\Tests\data\EntityObject::$jhvjjv or method Trinity\FrameworkBundle\Tests\data\EntityObject::jhvjjv()
     * @throws \Trinity\FrameworkBundle\Exception\MemberAccessException
     */
    public function testHing2(){
        $e = new EntityObject();
        $this->assertEquals(10, ObjectMixin::get($e, 'jhvjjv'));
    }
}