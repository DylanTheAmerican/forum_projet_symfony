<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserFormType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[IsGranted('ROLE_ADMINISTRATOR')]
#[Route('/admin', name: 'admin-')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findBy(
                [],
                ['username' => 'desc']
            ),
            
        ]);
    }

    #[Route('edit/{slug}', name: 'edit-bySlug')]
    public function editUser(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(EditUserFormType::class, $user);
        $form->handleRequest($request);

        if ($this->getUser() && $form->isSubmitted() && $form->isValid()) {
            /** @var User $author */
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin-main');
        }

        return $this->render('admin/admin.edit.html.twig', [
            'editUserForm' => $form->createView(),
            'user' => $user,
        ]);
    }
}
