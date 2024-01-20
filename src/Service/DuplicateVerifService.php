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

//        Si l'utilisateur n'est pas connecté, on ne fait rien

        if (!empty($duplicates)) {
            $url = '/doublon/' . $duplicates[0][1] . '/' . $duplicates[0][0];
            // Vérifier si l'URL de destination est différente de l'URL actuelle
            if ($this->getCurrentUrl() !== $url) {
                if ($this->getCurrentUrl() === '/doublon/' . $duplicates[0][1] . '/' . $duplicates[0][0]. '?cancel=1'){
                    $this->cancel($duplicates[0][0]);
                }elseif ($this->getCurrentUrl() === '/doublon/' . $duplicates[0][1] . '/' . $duplicates[0][0]. '?create=1'){
                    $this->createAnyways($duplicates[0][0]);
                }else{
                    // Rediriger vers l'URL de destination
                    $response = new RedirectResponse($url);
                    $response->send();
                    exit;
                }
            }
        }
    }

    public function createAnyways($id):void
    {
        $homework = $this->entityManager->getRepository(Homework::class)->find($id);
        $homework->setIsVerified(true);
        $this->entityManager->persist($homework);
        $this->entityManager->flush();
        $response = new RedirectResponse('/');
        $response->send();
        exit;
    }

    public function cancel($id):void
    {
        $homework = $this->entityManager->getRepository(Homework::class)->find($id);
        $this->entityManager->remove($homework);
        $this->entityManager->flush();
        $response = new RedirectResponse('/');
        $response->send();
        exit;
    }

    private function getCurrentUrl(): string
    {
        $currentUrl = $_SERVER['REQUEST_URI'];
        return $currentUrl;
    }


}
