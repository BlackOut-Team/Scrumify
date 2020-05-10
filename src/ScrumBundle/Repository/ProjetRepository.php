<?php

namespace ScrumBundle\Repository;

/**
 * ProjetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjetRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAll($user)
    {
        $now =new \DateTime('now');


        $qb = $this->createQueryBuilder("e");
        $qb ->join('TeamBundle:team_user','t' )
            ->andWhere('t.userId = :user' )
            ->andWhere('e.team = t.teamId')
            ->andWhere('e.etat = 1')
            ->setParameter('user',$user );

        return $result = $qb->getQuery()->getResult();


    }
    public function getCurrent($user)
    {
        $now =new \DateTime('now');


        $qb = $this->createQueryBuilder("e");
        $qb ->join('TeamBundle:team_user','t' )
            ->andWhere('t.userId = :user' )
            ->andWhere('e.team = t.teamId')
            ->andWhere('e.duedate > :now ')
            ->andWhere('e.etat = 1')
            ->setParameters(array('now'=>$now , 'user'=>$user) );

        return $result = $qb->getQuery()->getResult();


    }
    public function getCompleted($user)
    {
        $now =new \DateTime('now');


        $qb = $this->createQueryBuilder("e");
        $qb ->join('TeamBundle:team_user','t' )
            ->andWhere('t.userId = :user' )
            ->andWhere('e.team = t.teamId')
            ->andWhere('e.duedate < :now ')
            ->andWhere('e.etat = 1')
            ->setParameters(array('now'=>$now , 'user'=>$user) );

        return $result = $qb->getQuery()->getResult();


    }
    public function getMaster($user)
    {

        $qb = $this->createQueryBuilder('p');
        $qb

            ->join('TeamBundle:team_user','t' )
            ->andWhere('t.userId = :user' )
            ->andWhere('p.team = t.teamId')
            ->andWhere('t.role = 1')
            ->setParameter('user', $user);
       // var_dump($qb->getQuery()->getResult());
        return $result = $qb->getQuery()->getResult();

    }
    public function getOwner($user)
    {

        $qb = $this->createQueryBuilder('p');
        $qb

            ->join('TeamBundle:team_user','t' )
            ->andWhere('t.userId = :user' )
            ->andWhere('p.team = t.teamId')
            ->andWhere('t.role = 3')
            ->setParameter('user', $user);
       // var_dump($qb->getQuery()->getResult());
        return $result = $qb->getQuery()->getResult();

    }
    public function getDev($user)
    {

        $qb = $this->createQueryBuilder('p');
        $qb

            ->join('TeamBundle:team_user','t' )
            ->andWhere('t.userId = :user' )
            ->andWhere('p.team = t.teamId')
            ->andWhere('t.role = 2')
            ->setParameter('user', $user);
        //var_dump($qb->getQuery()->getResult());
        return $result = $qb->getQuery()->getResult();

    }
}
