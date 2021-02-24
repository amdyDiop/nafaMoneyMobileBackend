<?php

namespace App\DataFixtures;

use App\Entity\Profil;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProfilFixtures extends Fixture
{

    public const Profil_User = 'user';
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $profils = ['Caissier', 'AdminAgence', 'Admin', "UserAgence"];
        foreach ($profils as $i=>$value){
            $profil = new Profil();
            $profil->setLibelle($value);
            $this->addReference(self::Profil_User.$i, $profil);
            $manager->persist($profil);
        }
        $manager->flush();
    }
}


/**   $faker = Factory::create('fr_FR');
 *
 * for ($i = 0;
 * $i < 4;
 * $i++) {
 * $profil = new Profil();
 * $profil->setLibelle($faker->unique()->randomElement(['ADMIN', 'Formateur', 'CM', "Apprennant"]));
 * $manager->persist($profil);
 * $user = new User();
 * $password = $this->encoder->encodePassword($user, "password");
 * $user->setPassword($password);
 * $user->setPrenom($faker->firstName);
 * $user->setNom($faker->lastName);
 * $user->setEmail($faker->email);
 * $user->setAdresse($faker->address);
 * $user->setArchiver(0);
 * $user->setTelephone($faker->unique()->randomElement(['77347343', '769834924', '788439440', '70823920']));
 * $user->setGenre($faker->randomElement(['homme', 'femme']));
 * $user->setProfil($profil);
 * $manager->persist($user);
 * $manager->flush();
 *
 * $manager->flush();
 *
 * }
 */
