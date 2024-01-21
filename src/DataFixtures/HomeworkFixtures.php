<?php

namespace App\DataFixtures;

use App\Repository\SubjectRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Homework;

class HomeworkFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UserRepository $userRepository, private SubjectRepository $subjectRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userRepository->findBy(['email' => 'brandon.clement@etudiant.univ-reims.fr'])[0];
        for ($i = 0; $i < 10; ++$i) {
            $homework = new Homework();
            $homework->setName('Homework '.$i);
            $homework->setDescription('Description '.$i);
            $homework->setDueDate(new \DateTime('now + '.rand(1, 10).' days'));
            $homework->setAuthor($user);
            $homework->setSubject($this->subjectRepository->findBy([
                'course' => $user->getCourse(),
            ])[0]);
            $homework->setYear(2);
            $homework->setGroup('E');
            $homework->setTeacher('John Doe');
            $homework->setPlatform('Moodle');
            $homework->setIsVerified(1);

            $manager->persist($homework);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class, SubjectFixtures::class];
    }
}
