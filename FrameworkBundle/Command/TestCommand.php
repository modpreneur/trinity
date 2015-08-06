<?php


namespace Trinity\FrameworkBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Trinity\FrameworkBundle\Entity\CronTask;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class TestCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('test:run')
            ->setDescription('Runs Cron Tasks if needed')
            ->addArgument(
                'namespace',
                InputArgument::REQUIRED,
                'Who do you want to greet?'
            )
            ->addArgument(
                'argument',
                InputArgument::REQUIRED,
                'Who do you want to greet?'
            );
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cronTask = new CronTask();

        $namespace = $input->getArgument('namespace');
        $argument = $input->getArgument('argument');

        $cronTask->setCommand(array(
            $namespace, $argument
        ));
        $cronTask->setCreationTime(new \DateTime("now"));

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($cronTask);
        $em->flush();

        $output->writeln("Insert to database is complete!");
    }
}