<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class UserProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function index(ManagerRegistry $doctrine, UserInterface $user): Response
    {
        dump($user);
        return $this->render('profil/index.html.twig', [
            'user' => $user
        ]);
    }
}
