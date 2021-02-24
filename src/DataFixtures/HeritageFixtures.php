<?php

namespace App\DataFixtures;
use App\Entity\AdminAgence;
use App\Entity\AdminSysteme;
use App\Entity\Caissier;
use App\Entity\UserAgence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HeritageFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('fr_FR');
        $Tab=[ AdminAgence::class,Caissier::class,AdminSysteme::class, UserAgence::class];
        for ($i = 0; $i < 4; $i++) {
            $user = new $Tab[$i];
            $password = $this->encoder->encodePassword($user, "password");
            $user
                ->setPassword($password)
                ->setPrenom($faker->firstName)
                ->setNom($faker->lastName)
                ->setEmail($faker->email)
                ->setAdresse($faker->address)
                ->setTelephone($faker->unique()->randomElement(['77347343', '769834924', '788439440', '70823920']))
                ->setGenre($faker->randomElement(['homme', 'femme']))
                ->setProfil($this->getReference(ProfilFixtures:: Profil_User.$i));
            $manager->persist($user);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return array(
            ProfilFixtures::class,
        );
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
