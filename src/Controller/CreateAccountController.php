<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AddAccountType;
use App\Form\AddMoneyType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Uid\Uuid;

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
            $uuid = Uuid::v4();
            $account->setAccountId($uuid);
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

    #[Route('/accounts/archive/{accountId}', name: 'archive-account')]
    public function archive(ManagerRegistry $doctrine, $accountId): Response
    {
        $uuid = Uuid::fromString($accountId);
        $entityManager = $doctrine->getManager();
        $accountSingle = $doctrine->getRepository(Account::class)->findOneBy(['accountId' => $uuid]);
        $accountSingle ->setStatus('archive');
        $entityManager->flush();
        return $this->redirectToRoute("accounts");
    }

    #[Route('/accounts/virement/{id}', name: 'virement-account')]
    //public function index(): Response
    public function virement(ManagerRegistry $doctrine, Request $request,EntityManagerInterface $entityManager,  $id): Response
    {
        $entityManager = $doctrine->getManager();
        $accountSingle = $doctrine->getRepository(Account::class)->find($id);
        $form = $this->createForm(AddMoneyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dump($accountSingle ->getMoney());
            //dump($form->getData()["money"]);die();

            $accountSingle->setMoney((float)$form->getData()["money"] + $accountSingle ->getMoney());

            $entityManager->persist($accountSingle);
            $entityManager->flush();

            return $this->redirectToRoute('accounts');
        }
        return $this->renderForm('virement_account/index.html.twig', [
            'form' => $form,
        ]);
    }
}
