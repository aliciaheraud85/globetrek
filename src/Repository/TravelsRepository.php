<?php

namespace App\Repository;

use App\Entity\Travels;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Travels>
 */
class TravelsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Travels::class);
    }
    
    //méthode pour compter le nombre d'annonces de voyage
       public function countTravels(): int
       {
           return (int) $this->createQueryBuilder('t')
               ->select('COUNT(t.id)')
               ->getQuery()
               ->getSingleScalarResult();
           ;
       }

       public function travelsAfrica(): int
       {
         return(int) $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.categories = 1')
            ->getQuery()
            ->getSingleScalarResult();
        }

        public function travelsAmerica(): int
        {
          return(int) $this->createQueryBuilder('t')
             ->select('COUNT(t.id)')
             ->where('t.categories = 2')
             ->getQuery()
             ->getSingleScalarResult();
        }

        public function travelsOceania(): int
        {
          return(int) $this->createQueryBuilder('t')
             ->select('COUNT(t.id)')
             ->where('t.categories = 3')
             ->getQuery()
             ->getSingleScalarResult();
        }

        public function travelsAsia(): int
        {
          return(int) $this->createQueryBuilder('t')
             ->select('COUNT(t.id)')
             ->where('t.categories = 4')
             ->getQuery()
             ->getSingleScalarResult();
        }

         public function travelsEurope(): int
        {
          return(int) $this->createQueryBuilder('t')
             ->select('COUNT(t.id)')
             ->where('t.categories = 5')
             ->getQuery()
             ->getSingleScalarResult();
        }

}
