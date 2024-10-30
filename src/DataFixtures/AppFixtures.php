<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Velo;
use Faker\Generator;
use App\Entity\Categorie;
use App\Entity\Details;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $velos = [];

        // Création des catégories
        $categories = [];
        for ($j = 1; $j <= 10; $j++) {
            $categorie = new Categorie();
            $categorie->setName($this->faker->word())
                ->setDescription($this->faker->text(200));
            $manager->persist($categorie);
            $categories[] = $categorie;
        }

        // Vélos
        for ($i = 1; $i <= 50; $i++) {
            $velo = new Velo();

            // Association aléatoire d'une catégorie à un vélo
            $categorie = $categories[array_rand($categories)];

            $velo->setName($this->faker->word())
                ->setMarque($this->faker->word())
                ->setPrix(mt_rand(999, 2499))
                ->setCategorie($categorie)
                ->setImageName($this->faker ->imageUrl(640, 480, 'bike', true));


            $velos[] = $velo;

            $manager->persist($velo);
        }

        // Users
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFullName($this->faker->name())
                ->setPseudo(mt_rand(0, 1) === 1 ? $this->faker->firstName() : null)
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');

            $manager->persist($user);
        }

        $manager->flush();
    }
}
