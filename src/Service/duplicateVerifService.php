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
    public function getAllHomeworks(): array
    {
        return $this->entityManager->getRepository(Homework::class)->findAll();
    }

    // Récupération des devoirs qui ne sont pas vérifiés (isVerified = false) ou (isVerified = null)
    // Récupération des devoirs qui ne sont pas vérifiés (isVerified = false) ou (isVerified = null)
    public function getUncheckedHomeworks(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder
            ->select('h')
            ->from(Homework::class, 'h')
            ->where($queryBuilder->expr()->in('h.isVerified', ':isVerified'))
            ->orWhere('h.isVerified IS NULL')
            ->setParameter('isVerified', [false, null]);

        return $queryBuilder->getQuery()->getResult();
    }



    // Ajouter les non en isVerified = true dans la BDD
    public function addIsVerifiedTrue(array $noDuplicates): void
    {
        foreach ($noDuplicates as $noDuplicate) {
            // Utilisez find() au lieu de findBy() pour obtenir un seul résultat
            $homework = $this->entityManager->getRepository(Homework::class)->find($noDuplicate[0]);

            if ($homework instanceof Homework) {
                $homework->setIsVerified(true);
                $this->entityManager->persist($homework);
            }
        }

        // Flush une seule fois après la boucle
        $this->entityManager->flush();
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
                    if ($uncheckedHomework->getName() == $homework->getName()) {
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

    // Fonction qui va permettre de tout exécuter en une seule commande
    public function execute(): void
    {
        $this->addIsVerifiedTrue($this->checkDuplicates());
    }
}
