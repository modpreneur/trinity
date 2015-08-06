<?php

namespace Trinity\FrameworkBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use Trinity\FrameworkBundle\Entity\CronTask;

class CronTasksRunCommand extends ContainerAwareCommand
{
    private $output;

    protected function configure()
    {
        $this
            ->setName('crontasks:run')
            ->setDescription('Runs Cron Tasks if needed');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<comment>Running Cron Tasks...</comment>');

        $this->output = $output;

        $repository = $this->getContainer()->get('doctrine')->getRepository('TrinityFrameworkBundle:CronTask');
        $cronTasks = $repository->findAllNullProcessingtime();
        if ($cronTasks == null) {
            $output->writeln('<comment>No data to procesing...</comment>');
        } else {

            $em = $this->getContainer()->get('doctrine')->getManager();
            foreach ($cronTasks as $cronTask) {

                $command = $cronTask->getCommand();
                $this->output = $this->runCommand($command, $input, $output);

                $cronTask->setProcessingTime(new \DateTime("now"));
                $em->persist($cronTask);

            }
            $em->flush();
        }

    }

    private function runCommand($command, InputInterface $input, OutputInterface $output)
    {
        $application = $this->getApplication();


        $output->writeln($command[0]);
        $application->find($command[0]);


        $length = (count($command));
        $output->writeln($length);
        $output->writeln($command);




//        for ($i = 1; $i < $length; $i++) {
//            $output->writeln($command[$i]);
//            $application->addArgument($command[$i]);
//            $output->writeln($command[$i]);
//        }

        // Send all output to the console
        $returnCode = $application->run($input, $output);

//        return $returnCode != 0;
    }
}