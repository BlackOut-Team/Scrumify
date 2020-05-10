<?php

namespace MainBundle\Repository;

use MainBundle\Entity\User;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function  getTeam($id)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('c')
            ->join('TeamBundle:team_user', 't', 'WITH', 't.userId = c.id')
            ->where('t.teamId = :team ')
            ->setParameter('team', $id);


        return $qb->getQuery()->execute();
    }
}
