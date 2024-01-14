<?php

namespace App\DataFixtures;

use App\Entity\Subject;
use App\Repository\CourseRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class SubjectFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    /**
     * @var CourseRepository
     */
    private CourseRepository $courseRepository;

    /**
     * @param CourseRepository $courseRepository
     */
    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function load(ObjectManager $manager): void
    {
        function getRandomColor(): string
        {
            return str_pad(dechex(mt_rand(0, 16777215)), 6, '0', STR_PAD_LEFT);
        }

        $mmi = $this->courseRepository->findOneBy(['name_code' => 'MMI']);

        $subject1 = new Subject();
        $subject1->setNameCode('WR301');
        $subject1->setName('Anglais');
        $subject1->setColor(getRandomColor());
        $subject1->setCourse($mmi);
        $manager->persist($subject1);

        $subject2 = new Subject();
        $subject2->setNameCode('WR302');
        $subject2->setName('Anglais Renforcé');
        $subject2->setColor(getRandomColor());
        $subject2->setCourse($mmi);
        $manager->persist($subject2);

        $subject3 = new Subject();
        $subject3->setNameCode('WR303');
        $subject3->setName('Design d\'expérience');
        $subject3->setColor(getRandomColor());
        $subject3->setCourse($mmi);
        $manager->persist($subject3);

        $subject4 = new Subject();
        $subject4->setNameCode('WR304');
        $subject4->setName('Culture numérique');
        $subject4->setColor(getRandomColor());
        $subject4->setCourse($mmi);
        $manager->persist($subject4);

        $subject5 = new Subject();
        $subject5->setNameCode('WR305');
        $subject5->setName('Stratégies de communication et marketing');
        $subject5->setColor(getRandomColor());
        $subject5->setCourse($mmi);
        $manager->persist($subject5);

        $subject6 = new Subject();
        $subject6->setNameCode('WR306');
        $subject6->setName('Référencement');
        $subject6->setColor(getRandomColor());
        $subject6->setCourse($mmi);
        $manager->persist($subject6);

        $subject7 = new Subject();
        $subject7->setNameCode('WR307');
        $subject7->setName('Expression, communication et rhétorique');
        $subject7->setColor(getRandomColor());
        $subject7->setCourse($mmi);
        $manager->persist($subject7);

        $subject8 = new Subject();
        $subject8->setNameCode('WR308');
        $subject8->setName('Écriture multimédia et narration');
        $subject8->setColor(getRandomColor());
        $subject8->setCourse($mmi);
        $manager->persist($subject8);

        $subject9 = new Subject();
        $subject9->setNameCode('WR309');
        $subject9->setName('Création et design interactif (UI)');
        $subject9->setColor(getRandomColor());
        $subject9->setCourse($mmi);
        $manager->persist($subject9);

        $subject10 = new Subject();
        $subject10->setNameCode('WR310');
        $subject10->setName('Culture artistique');
        $subject10->setColor(getRandomColor());
        $subject10->setCourse($mmi);
        $manager->persist($subject10);

        $subject11 = new Subject();
        $subject11->setNameCode('WR311');
        $subject11->setName('Audiovisuel et Motion design');
        $subject11->setColor(getRandomColor());
        $subject11->setCourse($mmi);
        $manager->persist($subject11);

        $subject12 = new Subject();
        $subject12->setNameCode('WR312');
        $subject12->setName('Développement Front et intégration');
        $subject12->setColor(getRandomColor());
        $subject12->setCourse($mmi);
        $manager->persist($subject12);

        $subject13 = new Subject();
        $subject13->setNameCode('WR313');
        $subject13->setName('Développement Back');
        $subject13->setColor(getRandomColor());
        $subject13->setCourse($mmi);
        $manager->persist($subject13);

        $subject14 = new Subject();
        $subject14->setNameCode('WR314');
        $subject14->setName('Déploiement de services');
        $subject14->setColor(getRandomColor());
        $subject14->setCourse($mmi);
        $manager->persist($subject14);

        $subject15 = new Subject();
        $subject15->setNameCode('WR315');
        $subject15->setName('Représentation et traitement de l\'information');
        $subject15->setColor(getRandomColor());
        $subject15->setCourse($mmi);
        $manager->persist($subject15);

        $subject16 = new Subject();
        $subject16->setNameCode('WR316');
        $subject16->setName('Gestion de projet');
        $subject16->setColor(getRandomColor());
        $subject16->setCourse($mmi);
        $manager->persist($subject16);

        $subject17 = new Subject();
        $subject17->setNameCode('WR317');
        $subject17->setName('Economie, gestion et droit du numérique');
        $subject17->setColor(getRandomColor());
        $subject17->setCourse($mmi);
        $manager->persist($subject17);

        $subject18 = new Subject();
        $subject18->setNameCode('WR318');
        $subject18->setName('Projet Personnel et Professionnel');
        $subject18->setColor(getRandomColor());
        $subject18->setCourse($mmi);
        $manager->persist($subject18);

        $subject19 = new Subject();
        $subject19->setNameCode('WR319');
        $subject19->setName('Symfony');
        $subject19->setColor(getRandomColor());
        $subject19->setCourse($mmi);
        $manager->persist($subject19);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CourseFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['subject'];
    }
}
