<?php

namespace App\Controller;

use App\Entity\Account;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

class AccountsController extends AbstractController
{
    #[Route('/accounts', name: 'accounts')]
    public function index(ManagerRegistry $doctrine, UserInterface $user): Response
    {

        return $this->render('accounts/index.html.twig', [
            'accountList' => $user->getAccounts(),
        ]);
    }

    #[Route('/accounts/{accountId}', name: 'accountsSingle')]

    public function singleAccount(ManagerRegistry $doctrine, $accountId, UserInterface $user): Response
    {

        $uuid = Uuid::fromString($accountId);
        $accountSingle = $doctrine->getRepository(Account::class)->findOneBy(['accountId' => $uuid]);
        if($accountSingle->GetUserId()->getId() != $user->getId()){
            return $this->redirectToRoute('accounts');
        }

        return $this->render('accounts/single.html.twig', [
            "account" => $accountSingle
        ]);
    }
}
