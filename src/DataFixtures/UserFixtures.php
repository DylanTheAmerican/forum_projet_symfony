<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(private UserPasswordHasherInterface $passwordEncoder,
    private SluggerInterface $slugger)
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $count = $this->faker->numberBetween(5, 20);
        for ($a = 0; $a < $count; $a++) {
            $this->createUser($manager);
        }

        $this->createUser($manager, [
            'username' => 'Loken32',
            'roles' => ['ROLE_AUTHOR', 'ROLE_ADMINISTRATOR'],
            'password' => 'DylanCampion',
            'firstname' => 'Dylan',
            'lastname' => 'Campion',
            'address' => 'Rue 12',
            'postalcode' => '32600',
            'city' => 'Isle Jourdain',
            'email' => 'dylan.campion@gmail.com',
            'phonenumber' => '0606060606',
        ]);

        $manager->flush();
    }

    public function createUser(ObjectManager $manager, array $data = [])
    {
        static $index = 0;

        $data = array_replace(
            [
                'username' => $this->faker->userName(),
                'roles' => ['ROLE_AUTHOR'],
                'password' => $this->faker->password(),
                'firstname' => $this->faker->firstName(),
                'lastname' => $this->faker->lastName(),
                'address' => $this->faker->address(),
                'postalcode' => $this->faker->postcode(),
                'city' => $this->faker->city(),
                'email' => $this->faker->email(),
                'phonenumber' => $this->faker->phoneNumber(),
               
            ],
            $data,
        );
        $user = (new User())
            ->setUsername($data['username'])
            ->setRoles($data['roles'])
            ->setPassword($data['password'])
            ->setFirstname($data['firstname'])
            ->setLastname($data['lastname'])
            ->setAddress($data['address'])
            ->setPostalcode($data['postalcode'])
            ->setCity($data['city'])
            ->setEmail($data['email'])
            ->setPhonenumber($data['phonenumber'])
            ->computeSlug($this->slugger);
            

        $user->setPassword($this->passwordEncoder->hashPassword($user, $data['password']));
        $manager->persist($user);
        $this->setReference('user-' . $index++, $user);
    }
}
