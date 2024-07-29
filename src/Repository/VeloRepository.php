<?php

namespace App\Repository;

use App\Entity\Velo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Velo>
 */
class VeloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Velo::class);
    }

    public function findAllOrder(): array
    {
        return $this->createQueryBuilder('u')
            ->addSelect('notes')
            ->leftJoin('u.notes', 'notes')
            ->addOrderBy('notes.rating', 'DESC')
            ->orderBy('u.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function searchVelo($keyword){
        return $this->createQueryBuilder('u')
            ->andWhere('u.name LIKE :keyword')
            ->setParameter('keyword', '%'.$keyword.'%')
            ->getQuery()
            ->getResult();
            
    }
    
}
