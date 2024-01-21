<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('brandon.clement@etudiant.univ-reims.fr');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $user->setFirstName('Brandon');
        $user->setLastName('Clement');
        $user->setRoles(['ROLE_USER', 'ROLE_MOD', 'ROLE_ADMIN']);
        $user->setYear(2);
        $user->setGroup('E');
        $user->setCourse($this->getReference('course_1'));
        $manager->persist($user);

        $user = new User();
        $user->setEmail('guillaume.gorvel@etudiant.univ-reims.fr');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $user->setFirstName('Guillaume');
        $user->setLastName('Gorvel');
        $user->setRoles(['ROLE_USER', 'ROLE_MOD', 'ROLE_ADMIN']);
        $user->setYear(2);
        $user->setGroup('E');
        $user->setCourse($this->getReference('course_1'));
        $manager->persist($user);

        $user = new User();
        $user->setEmail('evan.bombart@etudiant.univ-reims.fr');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $user->setFirstName('Evan');
        $user->setLastName('Bombart');
        $user->setRoles(['ROLE_USER', 'ROLE_MOD', 'ROLE_ADMIN']);
        $user->setYear(2);
        $user->setGroup('E');
        $user->setCourse($this->getReference('course_1'));
        $manager->persist($user);

        $user = new User();
        $user->setEmail('nelly.delaruelle@etudiant.univ-reims.fr');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $user->setFirstName('Nelly');
        $user->setLastName('Delaruelle');
        $user->setRoles(['ROLE_USER', 'ROLE_MOD', 'ROLE_ADMIN']);
        $user->setYear(2);
        $user->setGroup('E');
        $user->setCourse($this->getReference('course_1'));
        $manager->persist($user);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CourseFixtures::class];
    }
}
