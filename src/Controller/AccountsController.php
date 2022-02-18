<?php

namespace App\Controller;

use App\Entity\Account;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/accounts/{id}', name: 'accountsSingle')]
    public function singleAccount(ManagerRegistry $doctrine, $id): Response
    {
        $accountSingle = $doctrine->getRepository(Account::class)->find($id);
        //dump($accountSingle); die();
        return $this->render('accounts/single.html.twig', [
            "account" => $accountSingle
        ]);
    }
}
