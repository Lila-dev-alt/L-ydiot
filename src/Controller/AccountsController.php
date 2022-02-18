<?php

namespace App\Controller;

use App\Entity\Account;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class AccountsController extends AbstractController
{
    #[Route('/accounts', name: 'accounts')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $accountList = $doctrine->getRepository(Account::class)->findAll();
        return $this->render('accounts/index.html.twig', [
            'accountList' => $accountList,
        ]);
    }

    #[Route('/accounts/{accountId}', name: 'accountsSingle')]

    public function singleAccount(ManagerRegistry $doctrine, $accountId): Response
    {

        $uuid = Uuid::fromString($accountId);
        $accountSingle = $doctrine->getRepository(Account::class)->findOneBy(['accountId' => $uuid]);
        return $this->render('accounts/single.html.twig', [
            "account" => $accountSingle
        ]);
    }
}
