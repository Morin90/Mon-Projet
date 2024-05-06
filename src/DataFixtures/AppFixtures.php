<?php

namespace App\DataFixtures;
use Faker\Factory;
use App\Entity\Velo;
use Faker\Generator;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    /**
     *
     * @var Generator
     */
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        // Vélos
        for ($i=1; $i <= 50; $i++) { 
            $velo = new Velo();
            $categorie =new Categorie();
            $velo->setName($this->faker->word())
                    ->setPrix(mt_rand(999, 2499))
                    ->setCategorie($categorie);
                    $categorie->setName($this->faker->word());
                    $categorie->setDescription($this->faker->text(200));
                    $velos[] = $velo;
                $manager->persist($velo);
                $manager->persist($categorie);
        }
        
        //Categories
        for ($j=1; $j <= 10; $j++) { 
            $categorie = new Categorie();
            $categorie->setName($this->faker->word());
            $categorie->setDescription($this->faker->text(200));
            for ($k=0; $k < mt_rand(0, 9); $k++) {
                $categorie->addVelo($velos[mt_rand(0, count($velos)-1)]);
            }
            $manager->persist($categorie);
        }

        $manager->flush();
    }
}
