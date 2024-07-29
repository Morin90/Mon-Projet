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
            $details = new Details();
            $velo->setName($this->faker->word())
                    ->setMarque($this->faker->word())
                    ->setPrix(mt_rand(999, 2499))
                    ->setCategorie($categorie);
                    $categorie->setName($this->faker->word());
                    $categorie->setDescription($this->faker->text(200));
                    $details->setTaille($this->faker->word());
                    $details->setRoues(mt_rand(0, 9));
                    $details->setVitesse(mt_rand(0, 9));
                    $velos[] = $velo;
                $manager->persist($velo);
                $manager->persist($categorie);
                $manager->persist($details);
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
        
        //Users
        for ($i=0; $i < 10; $i++) { 
            $user = new User();
            $user->setFullName($this->faker->name())
                ->setPseudo(mt_rand(0,1) === 1 ? $this->faker->firstName() : null)
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');
                
            $manager->persist($user);
        }
        $manager->flush();
    }
}
