<?php

namespace App\Controller;

use App\Entity\Account;
use App\Repository\AccountRepository;
use App\Repository\TransactionRepository;
use App\Service\PrepareTransactionViewModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/account')]
class AccountController extends AbstractController
{
    #[Route('/', name: 'account_index', methods: ['GET'])]
    public function index(AccountRepository $accountRepository): Response
    {
        return $this->render('account/index.html.twig', [
            'accounts' => $accountRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'account_show', methods: ['GET'])]
    public function show(Account $account, TransactionRepository $transactionRepository, PrepareTransactionViewModel $prepareTransactionViewModel): Response
    {
         $relatedTransactions = $transactionRepository->findTransactionsRelatedToAccount($account);
         $transactionsForView = $prepareTransactionViewModel->prepareFromTransactionsRelatedToAccount($relatedTransactions, $account);

        return $this->render('account/show.html.twig', [
            'account'      => $account,
            'transactions' => $transactionsForView,
        ]);
    }
}
