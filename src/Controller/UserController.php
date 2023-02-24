<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegisterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/signup', name: 'app_user_signup')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): Response
    {
        if ($this->getUser()){
            return $this->redirectToRoute('app_dashboard');
        }
        $newUser = new User();
        $form = $this->createForm(UserRegisterType::class, $newUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $newUser->setEmail($form->get('email')->getData());
            $newUser->setRoles(['ROLE_USER']);
            $newUser->setPassword($passwordHasher->hashPassword($newUser, $form->get('password')->getData()));

            $doctrine->getManager()->persist($newUser);
            $doctrine->getManager()->flush();

            $this->addFlash('success', 'Registration completed. You can login now');

            return $this->redirectToRoute('app_user_signup');
        }
        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
