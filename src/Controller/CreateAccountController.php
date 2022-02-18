<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AddAccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateAccountController extends AbstractController
{
    #[Route('/account/create', name: 'create_account')]
    //public function index(): Response
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $account = new Account();

        $form = $this->createForm(AddAccountType::class, $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($account);
            $entityManager->flush();

            return $this->redirectToRoute('accounts');
        }

        return $this->renderForm('create_account/index.html.twig', [
            'addAccountForm' => $form,
        ]);
    }
}
