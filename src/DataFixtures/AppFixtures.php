<?php

namespace App\DataFixtures;
use App\Entity\Velo;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
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
        for ($i=1; $i <= 50; $i++) { 
            $velo = new Velo();
            $velo->setName($this->faker->word())
                    ->setPrix(mt_rand(999, 2499));
                $manager->persist($velo);
        }
        
        $manager->flush();
    }
}
