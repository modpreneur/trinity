<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class SystemLogRepository.
 */
class SystemLogRepository extends EntityRepository
{
    /**
     * Find the latest logs.
     */
    public function findLatest()
    {
        $qb = $this->createQueryBuilder('l');

        $qb->add('orderBy', 'l.id DESC');

        $qb->setMaxResults(200);

        //Get our query
        $q = $qb->getQuery();

        //Return result
        return $q->getResult();
    }

    /**
     * @return array
     */
    public function getLast()
    {
        return $this->findBy([], ['created' => 'DESC'], 10);
    }
}
