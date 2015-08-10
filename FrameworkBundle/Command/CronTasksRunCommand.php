<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Trinity\FrameworkBundle\Entity\CronTask;

/**
 * Class CronTasksRunCommand.
 */
class CronTasksRunCommand extends ContainerAwareCommand
{
    /** @var Output */
    private $output;



    protected function configure ()
    {
        $this
            ->setName('crontasks:run')
            ->setDescription('Runs Cron Tasks');
    }



    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<comment>Running Cron Tasks...</comment>');
        $this->output = $output;
        $repository = $this->getContainer()->get('doctrine')->getRepository('TrinityFrameworkBundle:CronTask');

        /** @var CronTask[] $cronTasks */
        $cronTasks = $repository->findAllNullProcessingtime();

        if ($cronTasks === null) {
            $output->writeln('<comment>No data to procesing...</comment>');
        } else {
            try {
                $em = $this->getContainer()->get('doctrine')->getManager();
                foreach ($cronTasks as $cronTask) {
                    $command = $cronTask->getCommand();
                    foreach ($command as $key => $value) {
                        if ($value !== null) {
                            $output->writeln(sprintf('Executing command: <comment>' . $value . '</comment>'));
                        }
                    }
                    // Run the command
                    $returnCode = $this->runCommand($command, $output);
                    if ($returnCode == 0) {
                        $output->writeln('<info>SUCCESS!</info>');
                        $cronTask->setProcessingTime(new \DateTime('now'));
                        $em->persist($cronTask);
                    } else {
                        $output->writeln('<error>ERROR!</error>');
                    }
                }
                $em->flush();
            } catch (\Exception $e) {
                $message = $e->getMessage();
                $output->writeln("<error>ERROR! $message </error>");
            }
        }
    }



    /**
     * Run command in console.
     *
     * @param array $command - Input field must be in the form $key => $value.
     *                                 First $key must be string "command" and first $value must be starting command.
     *                                 Next $keys are arguments.Example: Array('command' => 'swiftmailer:spool:send', '--message-limit' => '10')
     * @param OutputInterface $output
     *
     * @return int $returnCode
     *
     * @throws \Exception
     */
    private function runCommand ($command, OutputInterface $output)
    {
        $application = $this->getApplication();
        $application->setAutoExit(false);

        $input = new ArrayInput($command);
        $returnCode = $application->run($input, $output);

        return $returnCode;
    }
}
