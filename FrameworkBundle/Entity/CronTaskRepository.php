<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;

use Doctrine\ORM\EntityRepository;


/**
 * Class CronTaskRepository
 * @package Trinity\FrameworkBundle\Entity
 */
class CronTaskRepository extends EntityRepository
{
    /**
     * Get array of all CronTasks with processingtime is null.
     *
     * @return CronTask[]
     */
    public function findAllNullProcessingtime()
    {
        $query = $this->getEntityManager()->createQuery(
            '
            SELECT cronTask
            FROM TrinityFrameworkBundle:CronTask AS cronTask
            WHERE cronTask.processingTime IS NULL ORDER BY cronTask.creationTime DESC'
        );

        return $query->getResult();
    }


    /**
     * Get array of all CronTasks where command is command.
     *
     * @param array $command
     *
     * @return CronTask
     */
    public function findByCommand($command)
    {
        $query = $this->getEntityManager()->createQuery(
            '
            SELECT cronTask
            FROM TrinityFrameworkBundle:CronTask AS cronTask
            WHERE cronTask.command = :command
            '
        )->setParameter('command', $command);

        $result = $query->getResult();
        if (is_array($result)) {
            return $result[0];
        } else {
            return $result;
        }
    }


    /**
     * Insert unique Job to db
     *
     * @param array $command
     *
     * @param Boolean $procesTime
     *
     * @return CronTask|null
     */

    public function addJob($command, $procesTime = false)
    {
        if ($procesTime == false) {
            $query = $this->getEntityManager()->createQuery(
                '
			SELECT j.id
			FROM TrinityFrameworkBundle:CronTask AS j
			WHERE j.command = :command
		'
            )->setParameter('command', $command);
        } else {
            $query = $this->getEntityManager()->createQuery(
                '
			SELECT j.id
			FROM TrinityFrameworkBundle:CronTask AS j
			WHERE j.command = :command
			AND j.processingTime IS NULL
		'
            )->setParameter('command', $command);
        }

        $result = $query->getResult();

        if (count($result) == '0') {
            $newJob = new CronTask();
            $newJob->setCreationTime(new \DateTime('now'));
            $newJob->setCommand($command);

            $em = $this->getEntityManager();
            $em->persist($newJob);
            $em->flush();

            return $newJob;
        } else {
            return;
        }
    }

}
