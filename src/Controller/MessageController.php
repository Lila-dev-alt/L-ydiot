<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Message;
use App\Entity\User;
use App\Form\AskUserType;
use App\Form\SelectAccountType;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

class MessageController extends AbstractController
{
    #[Route('/accounts/demande/{accountId}', name: 'demande')]
    public function askUserMoney(ManagerRegistry $doctrine, Request $request, EntityManagerInterface $entityManager, $accountId, UserInterface $user): Response
    {

        $uuid = Uuid::fromString($accountId);
        $accountSingle = $doctrine->getRepository(Account::class)->findOneBy(['accountId' => $uuid]);
        if($accountSingle->GetUserId()->getId() != $user->getId()){
            return $this->redirectToRoute('accounts');
        }
        $message = new \App\Entity\Message();
        $form = $this->createForm(AskUserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();
            $message->setStatus('pending');
            $message->setMessageSender($accountSingle);
            $entityManager->persist($message);
            $entityManager->flush();
            $this->addFlash('success', 'Vous avez bien fait une demande de virement !');
            return $this->redirectToRoute('accountsSingle', [
                'accountId' => $accountId
            ]);
        }
        return $this->renderForm('demande/index.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/accounts/accept/{message}', name: 'accept')]
    public function AcceptDemande(Message $message, Request $request, UserInterface $user, AccountRepository $accountRepository, EntityManagerInterface $em){

        /** @var User $user */
        $form = $this->createForm(SelectAccountType::class, null, ['accounts' => $user->getAccounts()]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $compte = $form->getData();
            $compte = $compte["compte"];

            $messageRecipiant = $accountRepository->findOneBy(['id' => $compte->getId()]);
            $messageSender = $accountRepository->findOneBy(['id' => $message->getMessageSender()->getId()]);
            $mR = $messageRecipiant->setMoney(-(float)$message->getMoney() + $messageRecipiant ->getMoney());
            $mS = $messageSender->setMoney((float)$message->getMoney() + $messageSender ->getMoney());

            if ($mR->getMoney() > 0 ) {
                $em->persist($message->setStatus('accepted'));
                $em->persist($mR);
                $em->persist($mS);
                $em->flush();
                $this->addFlash('success', 'Vous avez bien été débité de ' . $message->getMoney() . '€');
                return $this->redirectToRoute('accounts');
            }else{
                $message->setStatus('refused');
                $em->persist($message);
                $em->flush();
                $this->addFlash('danger', "Virement refusé: vous n'avez pas assez d'argent sur le compte");
            }

        }
        return $this->renderForm('demande/accept.html.twig', [
            'form' => $form,
            'message' => $message
        ]);
    }
}
