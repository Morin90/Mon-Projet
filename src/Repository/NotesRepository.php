<?php

namespace App\Repository;

use App\Entity\Notes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Cast\Array_;

/**
 * @extends ServiceEntityRepository<Notes>
 */
class NotesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notes::class);
    }

    //    /**
    //     * @return Notes[] Returns an array of Notes objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('n.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    public function findAverageRating($id): ?array
    {
        // Création d'un QueryBuilder pour construire dynamiquement une requête DQL
        return $this->createQueryBuilder('n')
            // Sélectionne la moyenne des valeurs de la colonne 'rating' de l'entité notes
            ->select('AVG(n.rating)')
            // Ajout d'une condition pour filtrer les résultats par l'ID du vélo
            ->andWhere('n.velo = :id')
            // Définit la valeur du paramètre ':id' avec la valeur réelle passée en argument de la fonction
            ->setParameter('id', $id)
            // Crée la requête finale basée sur la construction du QueryBuilder
            ->getQuery()
            // Exécute la requête et récupère un seul résultat ou null s'il n'y a aucun résultat
            ->getOneOrNullResult();
    }
}
