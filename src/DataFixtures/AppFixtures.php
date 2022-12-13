<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Marque;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Faker\Factory;

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
       // Création des differentes marques
       $marques =[
        'Aston Martin',
        'Guillaume',
        'Peugeot',
        'Mercedes',
        'BMW'
       ];
       $tabMark =[];
       foreach ($marques as $mark ){
        $marque = new Marque();
        $marque->setName($mark);
        $tabMark [] = $marque;
        $manager->persist($marque);
       }

        $user = new User();
        $user->setUsername('adminFixtures');
        $user->setPassword('123123abc');
        $manager->persist($user);

        $fuelOptions = ['Essence', 'Diesel', 'Hybride'];      
        for($i=1; $i<=12; $i++){ 
            $article = new Annonce();
            $article->setTitle($this->faker->sentence(4))
                ->setDescription($this->faker->paragraph)
                ->setFuel($this->faker->randomElement($fuelOptions))
                ->setKm($this->faker->randomNumber(6, true))
                ->setAuthor($user)
                ->setIsVisible($this->faker->randomDigitNotNull(2,3,4,5,6,7,8,9))
                ->setLicence($this->faker->randomDigitNotNull(2,3,4,5,6,7,8,9))
                ->setModel($this->faker->sentence(3))
                ->setMarque($this->faker->randomElement($tabMark))
                ->setReference('abd123')
                ->setPrix($this->faker->randomNumber(6))
                ->setYear($this->faker->year())
                ->setImgfile($this->faker->imageUrl( 640, 480, 'cars', true));
            
                $manager->persist($article);
        }
        $manager->flush();

    




        
    }

}
