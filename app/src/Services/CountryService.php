<?php

namespace App\Services;

use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CountryRepository;

class CountryService
{
    private CountryRepository $repository;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Country::class);
    }

    /**
     * @param String $sorter
     * @return array|object[] Country
     */
    public function findAllSorting(string $sorter): array
    {
        $allCountries = $this->repository->findBy([], [$sorter => 'ASC']);
        return $allCountries;
    }
}