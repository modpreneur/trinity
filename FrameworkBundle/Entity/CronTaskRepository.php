<?php
/**
 * Created by PhpStorm.
 * User: IVO
 * Date: 3.8.2015
 * Time: 16:03
 */

namespace Trinity\FrameworkBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CronTaskRepository extends EntityRepository
{

    /**
     * Get array of all CronTasks with Processingtime is null.
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
     * @param int $command
     *
     * @return array
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