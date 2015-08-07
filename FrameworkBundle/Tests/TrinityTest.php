<?php
/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Tests;

use Trinity\FrameworkBundle\Entity\CronTask;
use Trinity\FrameworkBundle\Command;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;

/**
 * Class TrinityTest
 */
class TrinityTest extends BaseTest
{
    /**
     * @var array Test command
     */
    private $command = array(
        'command' => "cache:clear",
        '-q' => "");


    /**
     * Test clear database
     */
    public function testDropCreateDatabase()
    {
        $kernel = $this->kernel;
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $input = new ArrayInput(array('çommand' => 'doctrine:schema:update', '--force' => ''));
        $fp = tmpfile();
        $output = new StreamOutput($fp);
        $returnCode = $application->run($input, $output);
        $this->assertEquals(1, $returnCode);
    }


    /**
     * Insert Test
     * @depends testDropCreateDatabase
     */
    public function testInsertToDatabase()
    {
        $cronTask = new CronTask();

        $cronTask->setCommand($this->command);
        $creationTime = new \DateTime("now");
        $cronTask->setCreationTime($creationTime);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($cronTask);
        $em->flush();
        $this->assertEquals($cronTask->getCreationTime(),$creationTime);
    }


    /**
     * Chceck data in database Test
     * @depends testDropCreateDatabase
     */
    public function testCheckDataInDatabase()
    {
        $this->testInsertToDatabase();
        $repository = $this->getContainer()->get('doctrine')->getRepository('TrinityFrameworkBundle:CronTask');
        $cronTask = $repository->findByCommand($this->command);

        $this->assertEquals($this->command, $cronTask->getCommand());
    }


    /**
     * Test null processing time
     * @depends testDropCreateDatabase
     */
    public function testNullProcessingtime()
    {
        $this->testInsertToDatabase();
        $repository = $this->getContainer()->get('doctrine')->getRepository('TrinityFrameworkBundle:CronTask');
        $cronTask = $repository->findByCommand($this->command);
        $this->assertEmpty($cronTask->getProcessingTime());
    }


    /**
     * Test find all null processing time
     * @depends testDropCreateDatabase
     */
    public function testfindAllNullProcessingtime()
    {
        $this->testInsertToDatabase();
        $repository = $this->getContainer()->get('doctrine')->getRepository('TrinityFrameworkBundle:CronTask');
        $cronTasks = $repository->findAllNullProcessingtime();
        $this->assertNotEmpty($cronTasks);
    }


    /**
     * Test find by command
     * @depends testDropCreateDatabase
     */
    public function testCreationTime()
    {
        $this->testInsertToDatabase();
        $repository = $this->getContainer()->get('doctrine')->getRepository('TrinityFrameworkBundle:CronTask');

        /** @var CronTask $cronTask */
        $cronTask = $repository->findByCommand($this->command);
        $this->assertNotEmpty($cronTask->getCreationTime());
        $this->assertEquals($this->command,$cronTask->getCommand());
    }
}