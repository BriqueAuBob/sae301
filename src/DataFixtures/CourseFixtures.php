<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CourseFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $course1 = new Course();
        $course1->setNameCode('MMI');
        $course1->setName('Métiers du Multimédia et de l\'Internet');
        $manager->persist($course1);
        $this->addReference('course_1', $course1);

        $course2 = new Course();
        $course2->setNameCode('TC');
        $course2->setName('Techniques de Commercialisation');
        $manager->persist($course2);

        $course3 = new Course();
        $course3->setNameCode('GEA');
        $course3->setName('Gestion des Entreprises et des Administrations');
        $manager->persist($course3);

        $course4 = new Course();
        $course4->setNameCode('CJ');
        $course4->setName('Carrières Juridiques');
        $manager->persist($course4);

        $course5 = new Course();
        $course5->setNameCode('GEII');
        $course5->setName('Génie Electrique et Informatique Industrielle');
        $manager->persist($course5);

        $course6 = new Course();
        $course6->setNameCode('GMP');
        $course6->setName('Génie Mécanique et Productique');
        $manager->persist($course6);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['course'];
    }
}
