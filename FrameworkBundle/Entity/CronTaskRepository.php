<?php
/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CronTaskRepository extends EntityRepository
{

    /**
     * Get array of all CronTasks with processingtime is null.
     *
     * @return CronTask[]
     */
    public function findAllNullProcessingtime()
    {
        $query = $this->getEntityManager()->createQuery("
            SELECT cronTask
            FROM TrinityFrameworkBundle:CronTask AS cronTask
            WHERE cronTask.ProcessingTime IS NULL");

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
        $query = $this->getEntityManager()->createQuery("
            SELECT cronTask
            FROM TrinityFrameworkBundle:CronTask AS cronTask
            WHERE cronTask.Command = :command
            ")->setParameter('command', serialize($command));

        $result = $query->getResult();
        if (is_array($result)) {
            return $result[0];
        }else {
            return $result;
        }
    }
}