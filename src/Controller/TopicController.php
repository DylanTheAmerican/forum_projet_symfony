<?php

namespace App\Controller;

use Faker\Factory;
use Faker\Generator;

use App\Controller\Trait\RoleTrait;
use App\Entity\Topic;
use App\Entity\TopicAnswer;
use App\Entity\User;
use App\Form\TopicAnswerFormType;
use App\Form\AddTopicFormType;
use App\Form\TopicFormType;
use App\Repository\TopicAnswerRepository;
use App\Repository\TopicRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/topic', name: 'topic-')]
class TopicController extends AbstractController
{
    use RoleTrait;

    #[Route('/', name: 'main')]
    public function index(TopicRepository $topicRepository): Response
    {
        return $this->render('topic/index.html.twig', [
            'posts' => $topicRepository->findBy(
                [],
                ['published_date' => 'desc'],
                12,
                0
            ),
            
        ]);
    }

    #[Route('/{id<\d+>}/edit', name: 'editById')]
    #[Route('/{slug}/edit', name: 'editBySlug')]
    public function topicEdit(Request $request, Topic $topic, EntityManagerInterface $entityManager): Response
    {
        if ($response = $this->checkRole('ROLE_AUTHOR')) {
            return $response;
        }

        $form = $this->createForm(TopicFormType::class, $topic);
        $form->handleRequest($request);

        if ($this->getUser() && $form->isSubmitted() && $form->isValid()) {
            /** @var User $author */
            $entityManager->persist($topic);
            $entityManager->flush();
        }

        return $this->render('topic/topic.edit.html.twig', [
            'topic' => $topic,
            'topicForm' => $form->createView(),
        ]);
    }

    #[Route('/ajout', name: 'add')]
    public function topicAdd(Request $request, EntityManagerInterface $entityManager): Response
    {
        $topic= new Topic; 

        $this->faker = Factory::create('fr_FR');
        
        if ($response = $this->checkRole('ROLE_AUTHOR')) {
            return $response;
        }

        $form = $this->createForm(AddTopicFormType::class, $topic);
        $form->handleRequest($request);

        if ($this->getUser() && $form->isSubmitted() && $form->isValid()) {
            /** @var User $author */
            $topic->setPublishedDate(new \DateTimeImmutable());
            $topic->setSlug(str_replace(' ', '-', $topic->getTitle()));
            $topic->setAuthor($this->getUser());
            // $topic->setSlug( $this->$slugger->slug($topic->getTitle())->lower());
            $entityManager->persist($topic);
            $entityManager->flush();
        }

        return $this->render('topic/topic.add.html.twig', [
            'topic' => $topic,
            'topicForm' => $form->createView(),
        ]);
    }

    #[Route('/{id<\d+>}', name: 'byId')]
    #[Route('/{slug}', name: 'bySlug')]
    public function postView(Request $request,Topic $topic, EntityManagerInterface $entityManager, TopicAnswerRepository $topicAnswerRepository): Response
    {
        $topicAnswer = new TopicAnswer();
        $form = $this->createForm(TopicAnswerFormType::class, $topicAnswer);
        $form->handleRequest($request);

        if ($this->getUser() && $form->isSubmitted() && $form->isValid()) {
            /** @var User $author */
            $author = $this->getUser();
            $topicAnswer->setDate(new \DateTimeImmutable());
            $topicAnswer->setAuthor($author);

            $parentPostCommentId = (int)$request->get('parent_topic_answer_id', 0);
            if ($parentPostCommentId > 0) {
                $parentPostComment = $topicAnswerRepository->findOneBy(['id' => $parentPostCommentId]);
                $topicAnswer->setParentTopic($parentPostComment);
            }

            $topic->addAnswer($topicAnswer);

            $entityManager->persist($topicAnswer);
            $entityManager->flush();

            $topicAnswer = new TopicAnswer();
            $form = $this->createForm(TopicAnswerFormType::class, $topicAnswer);
        }

        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('parent_topic', null))
            ->orderBy(['date' => 'desc'])
            ->setMaxResults(5);

        return $this->render('topic/topic.html.twig', [
            'topic' => $topic,
            'postAnswerForm' => $form->createView(),
            'answers' => $topic->getAnswers()->matching($criteria),
        ]);
    }
}
