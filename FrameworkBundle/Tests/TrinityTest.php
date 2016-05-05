<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;
use Trinity\FrameworkBundle\Command;
use Trinity\FrameworkBundle\Entity\CronTask;
use Trinity\FrameworkBundle\Utils\AbstractWebTest;


/**
 * Class TrinityWebTest.
 */
class TrinityWebTest extends AbstractWebTest
{
    /**
     * @var string Test command
     */
    private $command = 'cache:clear -p --r 8';


    /**
     * Test clear database.
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
     * Insert Test.
     *
     * @depends testDropCreateDatabase
     */
    public function testInsertToDatabase()
    {
        $cronTask = new CronTask();

        $cronTask->setCommand($this->command);
        $creationTime = new \DateTime('now');
        $cronTask->setCreationTime($creationTime);
        $em = $this->getContainer()->get('doctrine')->getManager();

        $em->persist($cronTask);
        $em->flush();
        $this->assertEquals($cronTask->getCreationTime(), $creationTime);
    }


    /**
     * Check data in database Test.
     *
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
     * Test null processing time.
     *
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
     * Test find all null processing time.
     *
     * @depends testDropCreateDatabase
     */
    public function testFindAllNullProcessingTime()
    {
        $this->testInsertToDatabase();
        $repository = $this->getContainer()->get('doctrine')->getRepository('TrinityFrameworkBundle:CronTask');
        $cronTasks = $repository->findAllNullProcessingTime();
        $this->assertNotEmpty($cronTasks);
    }


    /**
     * Test find by command and NotEmpty creation time.
     *
     * @depends testDropCreateDatabase
     */
    public function testCreationTime()
    {
        $this->testInsertToDatabase();
        $repository = $this->getContainer()->get('doctrine')->getRepository('TrinityFrameworkBundle:CronTask');

        /** @var CronTask $cronTask */
        $cronTask = $repository->findByCommand($this->command);
        $this->assertNotEmpty($cronTask->getCreationTime());
        $this->assertEquals($this->command, $cronTask->getCommand());
    }


    /**
     * Test set command with parse.
     *
     * @depends testDropCreateDatabase
     */
    public function testSetCommandWithParse()
    {
        $newCronTask = new CronTask();
        $newCronTask->setCommand('cache:clear -p --r 8');
        $this->assertEquals($this->command, $newCronTask->getCommand());
    }


    /**
     * Test get command as string.
     *
     * @depends testDropCreateDatabase
     * @depends testSetCommandWithParse
     */
    public function testGetCommandAsString()
    {
        $stringCommand = 'cache:clear -g --s 8 -l';
        $newCronTask = new CronTask();
        $newCronTask->setCommand($stringCommand);
        $this->assertEquals($stringCommand, $newCronTask->getCommand());
    }

}
