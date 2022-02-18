<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AddAccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CreateAccountController extends AbstractController
{
    private $security;
    public function __construct( Security $security)
    {
        $this->security = $security;
    }
    #[Route('/account/create', name: 'create_account')]
    //public function index(): Response
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $account = new Account();

        $form = $this->createForm(AddAccountType::class, $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $account->setStatus('active');
            $account->setAccountId('123444');
            $account->setDateCreation(New \DateTime());
            $account->setUserId($user = $this->security->getUser());
            $entityManager->persist($account);
            $entityManager->flush();

            return $this->redirectToRoute('accounts');
        }

        return $this->renderForm('create_account/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/account/{id}/archive', name: 'archive-account')]
    //public function index(): Response
    public function archive(Request $request, EntityManagerInterface $entityManager): Response
    {

        return $this->renderForm('create_account/index.html.twig', [
            'addAccountForm' => $form,
        ]);
    }
}
