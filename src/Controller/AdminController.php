<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMINISTRATOR')]
#[Route('/admin', name: 'admin-')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'user')]
    public function index(): Response
    {
        $user = $this->getUser();
        
        return $this->render('admin/index.html.twig', [
            'user' => $user,
        ]);
    }
}
