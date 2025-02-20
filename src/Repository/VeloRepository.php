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
//Query Builder est le constrcuteur de requetes sql 
    return $this->createQueryBuilder('u')
        // Ajoute une sélection supplémentaire pour inclure les entités 'notes' associées à 'u'
        ->addSelect('notes')
        // Effectue une jointure à gauche (LEFT JOIN) entre 'u' et ses 'notes'
        ->leftJoin('u.notes', 'notes')
        // Ajoute un ordre de tri sur les 'notes' en fonction de leur 'rating' en ordre décroissant
        ->addOrderBy('notes.rating', 'DESC')
        // Trie également les résultats par le nom en ordre croissant
        ->orderBy('u.name', 'ASC')
        // Exécute la requête et renvoie les résultats sous forme de tableau
        ->getQuery()
        ->getResult();
}
public function searchVelo($keyword)
{

    return $this->createQueryBuilder('u')
        // Ajoute une condition pour filtrer les entités dont le nom ('name') contient le mot-clé recherché
        ->andWhere('u.name LIKE :keyword')
        // Définit le paramètre ':keyword' en entourant le mot-clé par des pourcentages pour permettre une recherche partielle (LIKE)
        ->setParameter('keyword', '%'.$keyword.'%')
        // Exécute la requête et renvoie les résultats sous forme de tableau
        ->getQuery()
        ->getResult();
}
    
}
