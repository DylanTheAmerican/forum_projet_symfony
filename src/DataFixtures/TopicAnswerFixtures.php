<?php

namespace App\DataFixtures;

use App\Entity\Topic;
use App\Entity\TopicAnswer;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\String\Slugger\SluggerInterface;

class TopicAnswerFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $count = $this->faker->numberBetween(30, 50);
        for ($a = 0; $a < $count; $a++) {
            $randomTopicId = $this->faker->numberBetween(0, 9);
            /** @var Topic $randomPost */
            $randomPost = $this->getReference('topic-' . $randomTopicId);

            $parent = $this->createComment($manager, $randomPost);
            $subCommentCount = $this->faker->numberBetween(0, 10);
            for ($b = 0; $b < $subCommentCount; $b++) {
                $this->createComment($manager, $randomPost, $parent);
            }
        }

        $manager->flush();
    }

    public function createComment(ObjectManager $manager, Topic $topic, TopicAnswer $parent = null)
    {
        $randomUserId = $this->faker->numberBetween(0, 4);
        /** @var User $randomUser */
        $randomUser = $this->getReference('user-' . $randomUserId);

        $minDate = $topic->getPublishedDate()->format('c');
        if ($parent) {
            $minDate = $parent->getDate()->format('c');
        }

        $date = \DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween($minDate, 'now'));

        $answer = new TopicAnswer();
        $answer->setAuthor($randomUser);
        $answer->setContent($this->faker->realText());
        $answer->setParentTopic($parent);
        $answer->setDate($date);
        $answer->setTopic($topic);

        $manager->persist($answer);
        return $answer;
    }

    public function getDependencies(): array
    {
        return [
            TopicFixtures::class,
            UserFixtures::class,
        ];
    }
}
