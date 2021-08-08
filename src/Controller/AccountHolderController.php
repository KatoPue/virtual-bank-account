<?php

namespace App\Controller;

use App\Entity\AccountHolder;
use App\Form\AccountHolderType;
use App\Repository\AccountHolderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/account/holder')]
class AccountHolderController extends AbstractController
{
    #[Route('/', name: 'account_holder_index', methods: ['GET'])]
    public function index(AccountHolderRepository $accountHolderRepository): Response
    {
        return $this->render('account_holder/index.html.twig', [
            'account_holders' => $accountHolderRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'account_holder_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $accountHolder = new AccountHolder();
        $form = $this->createForm(AccountHolderType::class, $accountHolder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($accountHolder);
            $entityManager->flush();

            return $this->redirectToRoute('account_holder_index');
        }

        return $this->render('account_holder/new.html.twig', [
            'account_holder' => $accountHolder,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'account_holder_show', methods: ['GET'])]
    public function show(AccountHolder $accountHolder): Response
    {
        return $this->render('account_holder/show.html.twig', [
            'account_holder' => $accountHolder,
        ]);
    }

    #[Route('/{id}/edit', name: 'account_holder_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AccountHolder $accountHolder): Response
    {
        $form = $this->createForm(AccountHolderType::class, $accountHolder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('account_holder_index');
        }

        return $this->render('account_holder/edit.html.twig', [
            'account_holder' => $accountHolder,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'account_holder_delete', methods: ['POST'])]
    public function delete(Request $request, AccountHolder $accountHolder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$accountHolder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($accountHolder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('account_holder_index');
    }
}
