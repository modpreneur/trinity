<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * Class CronTaskRepository
 * @package Trinity\FrameworkBundle\Entity
 */
class CronTaskRepository extends EntityRepository
{
    /**
     * Get array of all CronTasks with processingTime is null.
     *
     * @return array of CronTask
     */
    public function findAllNullProcessingTime()
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

        //@todo @TomasJancar How you know what is first, you Don't have any order in Query.
        // If command should be unique we can use getOneOrNullResult, but now is weird.
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
     * @param Boolean $processTime
     *
     * @return CronTask|null
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     */
    public function addJob($command, $processTime = false)
    {
        if ($processTime === false) {
            $query = $this->getEntityManager()->createQuery('
			  SELECT COUNT(j.id)
			  FROM TrinityFrameworkBundle:CronTask AS j
			  WHERE j.command = :command
		    ')->setParameter('command', $command);
        } else {
            $query = $this->getEntityManager()->createQuery('
			  SELECT COUNT(j.id)
			  FROM TrinityFrameworkBundle:CronTask AS j
			  WHERE j.command = :command
			  AND j.processingTime IS NULL
		    ')->setParameter('command', $command);
        }

        try {
            /** @var int $result */
            $result = $query->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return null;
        } catch (NoResultException $e) {
            return null;
        }
        if ($result === 0) {
            $newJob = new CronTask();
            $newJob->setCreationTime(new \DateTime('now'));
            $newJob->setCommand($command);
            $em = $this->getEntityManager();
            $em->persist($newJob);
            $em->flush();
            return $newJob;
        } else {
            return null;
        }
    }
}
