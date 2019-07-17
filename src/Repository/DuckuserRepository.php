<?php

namespace App\Repository;

use App\Entity\Duckuser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @method Duckuser|null find($id, $lockMode = null, $lockVersion = null)
 * @method Duckuser|null findOneBy(array $criteria, array $orderBy = null)
 * @method Duckuser[]    findAll()
 * @method Duckuser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DuckuserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Duckuser::class);
    }


    public function loadUserByUsername($DucknameOrEmail)
    {
        return $this->createQueryBuilder('u')
            ->where('u.duckname = :query OR u.email = :query')
            ->setParameter('query', $DucknameOrEmail)
            ->getQuery()
            ->getOneOrNullResult();
    }
    // /**
    //  * @return DuckUser[] Returns an array of DuckUser objects
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
    public function findOneBySomeField($value): ?DuckUser
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
