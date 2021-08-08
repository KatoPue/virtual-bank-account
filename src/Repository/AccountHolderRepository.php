<?php

namespace App\Repository;

use App\Entity\AccountHolder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AccountHolder|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccountHolder|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccountHolder[]    findAll()
 * @method AccountHolder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountHolderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountHolder::class);
    }
}
