<?php
namespace ForumBundle\Repository;
/**
 * QuestionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestionRepository extends \Doctrine\ORM\EntityRepository
{
    public function getOtherQuestions($user)
{
    $qb = $this->createQueryBuilder('u')
    ->join('u.tags', 't');
    $qb->where('u.User != :user')
        ->setParameter('user', $user)
    ->select('u','t');

    return $qb->getQuery()
        ->getResult();
}
    public function getOtherQuestionsByTag($user, $tag)
    {
         $qb = $this->createQueryBuilder('u')
            ->join('u.tags', 't')
            ->addSelect('u','t')
            ->where('u.User != :user AND t.name = :tag')
            ->setParameter('user', $user)
            ->setParameter('tag', $tag);

        return $qb->getQuery()
            ->getResult();
    }
    public function countForUser($user){
        return $this->createQueryBuilder('q')
            ->SELECT('COUNT(q.id)')
            ->where('q.User = :user')
            ->setParameter('user' , $user)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
