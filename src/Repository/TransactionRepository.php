<?php

namespace App\Repository;

use App\Entity\Account;
use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    /**
     * @param Transaction $transaction
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Transaction $transaction): void
    {
        $this->_em->persist($transaction);
        $this->_em->flush();
    }

    public function findTransactionsRelatedToAccount(Account $account): array
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->where('a.origin = :account')
            ->orWhere('a.target = :account')
        ;

        $queryBuilder->setParameter('account', $account);

        return $queryBuilder->getQuery()->getResult();
    }
}
