<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProfilController extends AbstractController
{

    
    #[Route('profil/{id}', name: 'profil')]
    public function index(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(EditUserFormType::class, $user);
        $form->handleRequest($request);

        if ($this->getUser() && $form->isSubmitted() && $form->isValid()) {
            /** @var User $author */
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Les informations de votre compte ont bien été modifiées'
            );

            return $this->redirectToRoute('profil' , ['id' => $user->getId()]);
        }

        return $this->render('profil/index.html.twig', [
            'userForm' => $form->createView(),
            'user' => $user,
        ]);
    }
}
