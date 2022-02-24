<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AddMoneyType;
use App\Form\TransferMoneyType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends AbstractController
{
    #[Route('/accounts/transaction/{accountId}', name: 'transaction-account')]
    public function virement(ManagerRegistry $doctrine, Request $request, EntityManagerInterface $entityManager,  $accountId): Response
    {

        //$accountSingle = $doctrine->getRepository(Account::class)->find($accountId);
        $accountSingle = $doctrine->getRepository(Account::class)->findOneBy(['accountId' => $accountId]);
        $form = $this->createForm(TransferMoneyType::class);
        $form->handleRequest($request);
        $error = false;
        if ($form->isSubmitted() && $form->isValid()) {
            if ($accountSingle-> getMoney() >= (float)$form->getData()["money"]){
                $recipient = $doctrine->getRepository(Account::class)->findOneBy(['iban' => $form->getData()["recipient"]]);
                if ($recipient == false ) {
                    $error = "aucun compte trouvé : Le numero IBAN est incorrect";
                } else {
                $recipient->setMoney((float)$form->getData()["money"] + $recipient ->getMoney());
                $accountSingle->setMoney(-(float)$form->getData()["money"] + $accountSingle ->getMoney());
                $entityManager->persist($accountSingle);
                $entityManager->persist($recipient);
                $entityManager->flush();
                return $this->redirectToRoute('accounts');
            }}
            else{
                $error = "Vous n'avez pas les fonds necessaires pour faire cette transaction";
            }

        }
        return $this->renderForm('transaction/index.html.twig', [
            'form' => $form,
            "error" => $error
        ]);
    }

}