<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;
use Trinity\FrameworkBundle\Entity\CronTask;


/**
 * Class TestCommand.
 */
class TestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('test:run')
            ->setDescription('Runs Cron Tasks if needed')
            ->addArgument(
                'InsertCommand',
                InputArgument::REQUIRED,
                'Who do you want to greet?'
            );
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cronTask = new CronTask();

        //dump($input->getArguments()['InsertCommand']);
        $input = new StringInput($input->getArguments()['InsertCommand']);

        $input->bind(new InputDefinition());

        // dump($input->getArguments());


        exit;
        $pole = preg_split('/ /', $string);

        if (count($pole) === 1) {
            $cronTask->setCommand(
                array(
                    'command' => $pole[0],
                )
            );
        } else {
            $cronTask->setCommand(
                array(
                    'command' => $pole[0],
                    $pole[1] => '',
                )
            );
        }
        $cronTask->setCreationTime(new \DateTime('now'));

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($cronTask);
        $em->flush();

        $output->writeln('Insert to database is complete!');
    }
}
