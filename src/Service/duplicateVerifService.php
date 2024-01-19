<?php
namespace App\Service;

use App\Entity\Homework;
use Doctrine\ORM\EntityManagerInterface;

class duplicateVerifService
{
    private $entityManager;

    // Constructeur
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Récupération de tous les devoirs
    public function getAllHomeworks() : array
    {
        return $this->entityManager->getRepository(Homework::class)->findAll();
    }

    // Récupération des devoirs qui ne sont pas vérifiés (isVerified = false)
    public function getUncheckedHomeworks() : array
    {
        return $this->entityManager->getRepository(Homework::class)->findBy(['isVerified' => false]);
    }

    // Ajouter les non en isVerified = true dans la BDD
    public function addIsVerifiedTrue($noDuplicates) : void
    {
//        Ajouter un console.log dans la console
        echo '<script>console.log('. json_encode( $noDuplicates ) .')</script>';
        foreach ($noDuplicates as $noDuplicate) {
            $homework = $this->entityManager->getRepository(Homework::class)->find($noDuplicate[0]);
            $homework->setIsVerified(true);
            $this->entityManager->persist($homework);
            $this->entityManager->flush();
        }
    }


    // Vérification des doublons
    public function checkDuplicates() : array
    {
        $homeworks = $this->getAllHomeworks();
        $uncheckedHomeworks = $this->getUncheckedHomeworks();
        //Tableau des doublons
        $duplicates = [];
        //Tableau des non doublons
        $noDuplicates = [];

        // On compare les devoirs non vérifiés avec tous les devoirs
        foreach ($uncheckedHomeworks as $uncheckedHomework) {
            foreach ($homeworks as $homework) {
                // On ne compare pas un devoir avec lui-même
                if ($uncheckedHomework->getId() != $homework->getId()) {
                    // On compare les devoirs par titre
                    if ($uncheckedHomework->getTitle() == $homework->getTitle()) {
                        // On ajoute les doublons au tableau des doublons
                        $duplicatesArray = [$uncheckedHomework->getId(), $homework->getId()];
                        $duplicates[] = $duplicatesArray;
                    }else{
                        // On ajoute les non doublons au tableau des non doublons
                        $noDuplicatesArray = [$uncheckedHomework->getId(), $homework->getId()];
                        $noDuplicates[] = $noDuplicatesArray;
                    }
                }
            }
        }
        // On ajoute les non doublons au tableau des non doublons
        $this->addIsVerifiedTrue($noDuplicates);

        return $duplicates;
    }

    // Fonction qui va permettre de tout executer en une seule comande
    public function execute() : void
    {
        $this->addIsVerifiedTrue($this->checkDuplicates());
    }
}