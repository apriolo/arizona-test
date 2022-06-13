<?php

namespace App\Services;

use App\Entity\Country;
use App\Factory\CountryFactory;
use Doctrine\ORM\EntityManagerInterface;

class CountryApiService
{
    private CountryFactory $countryFactory;
    private EntityManagerInterface $entityManager;
    private \Doctrine\ORM\EntityRepository $repository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param CountryFactory $countryFactory
     */
    public function __construct(EntityManagerInterface $entityManager, CountryFactory $countryFactory)
    {
        $this->countryFactory = $countryFactory;
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Country::class);
    }

    /**
     * Description - Function to create a new country
     * @param string $name
     * @param string $abbreviation
     * @return void
     */
    public function createCountry(string $name, string $abbreviation): bool
    {
        $countryFactory = $this->countryFactory->createCountry($name, $abbreviation);
        $this->entityManager->persist($countryFactory);
        $this->entityManager->flush();
        return true;
    }

    /**
     * Description - Function to get a list of Countries sorting
     * @param String $sorter
     * @return array|object[] Country
     */
    public function findAll(string $sorter): ?array
    {
        return $this->repository->findBy([], [$sorter => 'ASC']);
    }

    /**
     * Description - Function to get a country by id
     * @param int $id
     * @return Country
     */
    public function find(int $id): ?Country
    {
        return $this->repository->find($id);
    }

    /**
     * Description - Function to delete a country by id
     * @param Country $country
     * @return bool
     */
    public function deleteCountry(Country $country): bool
    {
        $this->entityManager->remove($country);
        $this->entityManager->flush();
        return true;
    }

    public function updateCountry(Country $country, array $data): bool
    {
        if (isset($data['name'])) {
            $country->setName($data['name']);
        }

        if (isset($data['abbreviation'])) {
            $country->setAbbreviation($data['abbreviation']);
        }

        $this->entityManager->persist($country);
        $this->entityManager->flush();

        return true;
    }
}
