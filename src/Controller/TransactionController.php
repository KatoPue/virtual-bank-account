<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Transaction;
use App\Enum\TransactionFormTypeMode;
use App\Exception\AccountBalanceTooLowException;
use App\Form\TransactionType;
use App\Repository\TransactionRepository;
use App\Service\UpdateAccountBalance;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/transaction')]
class TransactionController extends AbstractController
{
    #[Route('/', name: 'transaction_index', methods: ['GET'])]
    public function index(TransactionRepository $transactionRepository): Response
    {
        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactionRepository->findAll(),
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/{id}/deposit', name: 'transaction_deposit', methods: ['GET', 'POST'])]
    public function deposit(
        Request $request,
        Account $account,
        TransactionRepository $transactionRepository,
        UpdateAccountBalance $updateAccountBalance,
    ): Response
    {
        $transaction = new Transaction();
        $transaction->setTarget($account);

        $form = $this->createForm(TransactionType::class, $transaction, [
            'usage_context' => TransactionFormTypeMode::DEPOSIT()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Transaction $transaction */
            $transaction = $form->getData();

            try {
                $updateAccountBalance->updateAccountsLinkedToTransaction($transaction);
                $transactionRepository->save($transaction);
            } catch (AccountBalanceTooLowException $exception) {
                $this->addFlash('error', 'This transaction would result in a negative account balance. Please check the amount and your current balance.');

                return $this->render('transaction/deposit.html.twig', [
                    'account' => $account,
                    'form'    => $form->createView(),
                ]);
            }

            $this->addFlash('success', 'Transaction successfully completed.');

            return $this->redirectToRoute('account_show', ['id' => $account->getId()]);
        }

        return $this->render('transaction/deposit.html.twig', [
            'account' => $account,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/{id}/withdraw', name: 'transaction_withdraw', methods: ['GET', 'POST'])]
    public function withdraw(
        Request $request,
        Account $account,
        TransactionRepository $transactionRepository,
        UpdateAccountBalance $updateAccountBalance,
    ): Response
    {
        $transaction = new Transaction();
        $transaction->setOrigin($account);

        $form = $this->createForm(TransactionType::class, $transaction, [
            'usage_context' => TransactionFormTypeMode::WITHDRAW()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Transaction $transaction */
            $transaction = $form->getData();

            try {
                $updateAccountBalance->updateAccountsLinkedToTransaction($transaction);
                $transactionRepository->save($transaction);
            } catch (AccountBalanceTooLowException $exception) {
                $this->addFlash('error', 'This transaction would result in a negative account balance. Please check the amount and your current balance.');

                return $this->render('transaction/withdraw.html.twig', [
                    'account' => $account,
                    'form'    => $form->createView(),
                ]);
            }

            $this->addFlash('success', 'Transaction successfully completed.');

            return $this->redirectToRoute('account_show', ['id' => $account->getId()]);
        }

        return $this->render('transaction/withdraw.html.twig', [
            'account' => $account,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/{id}/transfer', name: 'transaction_transfer', methods: ['GET', 'POST'])]
    public function transfer(
        Request $request,
        Account $account,
        TransactionRepository $transactionRepository,
        UpdateAccountBalance $updateAccountBalance,
    ): Response
    {
        $transaction = new Transaction();
        $transaction->setOrigin($account);

        $form = $this->createForm(TransactionType::class, $transaction, [
            'usage_context' => TransactionFormTypeMode::TRANSFER()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Transaction $transaction */
            $transaction = $form->getData();

            try {
                $updateAccountBalance->updateAccountsLinkedToTransaction($transaction);
                $transactionRepository->save($transaction);
            } catch (AccountBalanceTooLowException $exception) {
                $this->addFlash('error', 'This transaction would result in a negative account balance. Please check the amount and your current balance.');

                return $this->render('transaction/transfer.html.twig', [
                    'account' => $account,
                    'form'    => $form->createView(),
                ]);
            }

            $this->addFlash('success', 'Transaction successfully completed.');

            return $this->redirectToRoute('account_show', ['id' => $account->getId()]);
        }

        return $this->render('transaction/transfer.html.twig', [
            'account' => $account,
            'form'    => $form->createView(),
        ]);
    }
}
