<?php

namespace App\Repository;

use App\Entity\Ducktable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @method Ducktable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ducktable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ducktable[]    findAll()
 * @method Ducktable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DucktableRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ducktable::class);
    }


    public function loadUserByUsername($DucknameOrEmail)
    {
        return $this->createQueryBuilder('u')
            ->where('u.Duckname = :query OR u.Email = :query')
            ->setParameter('query', $DucknameOrEmail)
            ->getQuery()
            ->getOneOrNullResult();
    }
    // /**
    //  * @return Ducktable[] Returns an array of Ducktable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ducktable
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
