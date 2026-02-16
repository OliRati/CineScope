<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AvatarUploadFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }
    #[Route('/profile/avatar', name: 'app_profile_avatar')]
    public function avatar(Request $request, EntityManagerInterface $entityManager): Response
    {
        $avatarFile = "";
        $form = $this->createForm(AvatarUploadFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avatarFile = $form->get(name: 'avatar')->getData();

            if ($avatarFile) {
                $newFilename = uniqid() . '.' . $avatarFile->guessExtension();

                $avatarFile->move(
                    $this->getParameter('avatars_directory'),
                    $newFilename
                );

                $securityUser = $this->getUser();
                $userRepository = $entityManager->getRepository(User::class);
                $user = $userRepository->findOneBy(['email' => $securityUser->getUserIdentifier()]);

                $user->setAvatar($newFilename);

                $entityManager->persist($user);
                $entityManager->flush();
      
                return $this->redirectToRoute('app_profile');
            }
        }

        return $this->render('profile/avatar.html.twig', [
            'avatarForm' => $form
        ]);
    }
}
