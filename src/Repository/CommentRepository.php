<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function findCommentByPost($travelsId){
        return $this->createQueryBuilder('c')
            ->where('c.travels = :travels')
            ->setParameter('travels', $travelsId)
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function countComments(): int
    {
        return (int) $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    
}
