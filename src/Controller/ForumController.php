<?php

namespace App\Controller;

use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(TopicRepository $topicRepository): Response
    {
        return $this->render('forum/index.html.twig', [
            'posts' => $topicRepository->findBy(
                [],
                ['published_date' => 'desc'],
                6,
                0
            ),
        ]);
    }
}
