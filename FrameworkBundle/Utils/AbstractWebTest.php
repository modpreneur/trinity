<?php

namespace Trinity\FrameworkBundle\Utils;

use Braincrafted\Bundle\TestingBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Trinity\Component\EntityCore\Entity\BaseUser as User;

/**
 * Class AbstractWebTest
 * @package Trinity\FrameworkBundle\Utils
 */
abstract class AbstractWebTest extends WebTestCase
{

    /** @var  Container */
    protected $container;

    /** @var  KernelInterface */
    protected $kernelObject;

    /** @var  Client */
    protected $client;


    /**
     *  set up
     */
    public function setUp()
    {
        parent::setUp();

        $this->client = $this->createClient();
        $this->logIn();
    }


    /**
     * log in
     */
    private function logIn()
    {
        $firewall = 'dev';
        $user = new User();
        $this->setPropertyValue($user, 'id', 1);
        $token = new UsernamePasswordToken('ryanpass', null, $firewall, array('ROLE_ADMIN'));
        $token->setUser($user);

        $this->client->getContainer()->get('security.token_storage')->setToken($token);

        $session = $this->client->getContainer()->get('session');
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }


    /**
     * @param string|object $class
     * @param string $name
     *
     * @return \ReflectionMethod
     */
    protected static function getMethod($class, $name)
    {
        $class = new \ReflectionClass($class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }


    /**
     * @param object $class
     * @param string $property
     * @param $value
     */
    protected function setPropertyValue($class, $property, $value)
    {
        $property = new \ReflectionProperty($class, $property);
        $property->setAccessible(true);
        $property->setValue($class, $value);
    }


    /**
     * @param bool $mock
     * @return EntityManager
     */
    protected function getEM($mock = false)
    {
        if ($mock) {
            $em = $this->getMockBuilder('Doctrine\ORM\EntityManager')->setMethods([
                    'getRepository',
                    'getUnitOfWork',
                ])->disableOriginalConstructor()->getMock();

            $uow = $this->getMockBuilder('\Doctrine\ORM\UnitOfWork')->disableOriginalConstructor()->getMock();

            $uow->method('getEntityChangeSet')->willReturn(['name' => 'New name']);
            $em->method('getUnitOfWork')->willReturn($uow);

        } else {
            return $this->getContainer()->get('doctrine.orm.default_entity_manager');
        }

        return $em;
    }

}