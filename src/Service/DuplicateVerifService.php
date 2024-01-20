<?php

namespace App\Service;

use AllowDynamicProperties;
use App\Entity\Homework;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;


#[AllowDynamicProperties]
class DuplicateVerifService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllHomeworks(): array
    {
        return $this->entityManager->getRepository(Homework::class)->findAll();
    }

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

    public function addIsVerifiedTrue(array $noDuplicates): void
    {
        foreach ($noDuplicates as $noDuplicate) {
            $homework = $this->entityManager->getRepository(Homework::class)->find($noDuplicate);

            if ($homework instanceof Homework) {
                $homework->setIsVerified(true);
                $this->entityManager->persist($homework);
            }
        }

        $this->entityManager->flush();
    }

    public function checkDuplicates(): array
    {
        $homeworks = $this->getAllHomeworks();
        $uncheckedHomeworks = $this->getUncheckedHomeworks();
        $duplicates = [];
        $noDuplicates = [];
        $checkedPairs = [];

        foreach ($uncheckedHomeworks as $uhw) {
            $idUncheck = $uhw->getId();
            $foundDuplicate = false;

            foreach ($homeworks as $hw) {
                $idCheck = $hw->getId();

                if (in_array([$idUncheck, $idCheck], $checkedPairs) || in_array([$idCheck, $idUncheck], $checkedPairs)) {
                    continue;
                }

                if ($idCheck !== $idUncheck) {
                    if ($uhw->getName() === $hw->getName()) {
                        array_push($duplicates, [$idUncheck, $idCheck]);
                        $foundDuplicate = true;
                    }
                }

                $checkedPairs[] = [$idUncheck, $idCheck];
            }

            if (!$foundDuplicate) {
                $noDuplicates[] = $idUncheck;
            }
        }

        if (!empty($noDuplicates)) {
            $this->addIsVerifiedTrue($noDuplicates);
        }

        return $duplicates;
    }

    public function execute(): void
    {
        $duplicates = $this->checkDuplicates();

        if (!empty($duplicates)) {
            $url = '/doublon/' . $duplicates[0][1] . '/' . $duplicates[0][0];

            // Vérifier si l'URL de destination est différente de l'URL actuelle
            if ($this->getCurrentUrl() !== $url) {
                $response = new RedirectResponse($url);
                $response->send();
                exit;
            }
        }
    }

    private function getCurrentUrl(): string
    {
        $currentUrl = $_SERVER['REQUEST_URI'];
        return $currentUrl;
    }


}
