<?php

use Trinity\FrameworkBundle\Entity\CronTask;
use Trinity\FrameworkBundle\Command;

/**
 * Class TrinityTest
 */
class TrinityTest extends \Braincrafted\Bundle\TestingBundle\Test\WebTestCase
{
    private $command = array(
        "testNamespace",
        "testArg1",
        "testArg2");

    /**
     * Empty Test
     */
    public function testEmptyTest()
    {
        $this->assertTrue(TRUE);
    }

    /**
     * Insert Test
     */
    public function testInsertToDatabase()
    {
        $cronTask = new CronTask();

        $cronTask->setCommand($this->command);
        $cronTask->setCreationTime(new \DateTime("now"));

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($cronTask);
        $em->flush();
    }

    public function testCheckDataInDatabase()
    {
        $this->testInsertToDatabase();
        $repository = $this->getContainer()->get('doctrine')->getRepository('TrinityFrameworkBundle:CronTask');
        $cronTask = $repository->findByCommand($this->command);

        $this->assertEquals($this->command, $cronTask->getCommand());
    }

    public function testNullProcessingtime()
    {
        $this->testInsertToDatabase();
        $repository = $this->getContainer()->get('doctrine')->getRepository('TrinityFrameworkBundle:CronTask');
        $cronTask = $repository->findByCommand($this->command);
        $this->assertEmpty($cronTask->getProcessingTime());
    }

    public function testfindAllNullProcessingtime()
    {
        $this->testInsertToDatabase();
        $repository = $this->getContainer()->get('doctrine')->getRepository('TrinityFrameworkBundle:CronTask');
        $cronTasks = $repository->findAllNullProcessingtime();
        $this->assertNotEmpty($cronTasks);
    }

    public function testCreationTime()
    {
        $this->testInsertToDatabase();
        $repository = $this->getContainer()->get('doctrine')->getRepository('TrinityFrameworkBundle:CronTask');
        $cronTask = $repository->findByCommand($this->command);
        $this->assertNotEmpty($cronTask->getCreationTime());
    }







}