<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Message;
use App\Entity\User;
use App\Repository\MessageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function index(UserInterface $user, MessageRepository $repo): Response
    {
        $messages = $repo->findBy(['recipient' => $user]);

        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'messages' => $messages
        ]);
    }
}
