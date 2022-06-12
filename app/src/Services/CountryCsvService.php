<?php

namespace App\Services;

use App\Entity\Country;
use App\Factory\CountryFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CountryCsvService
{
    private string $projectDir;
    private EntityManagerInterface $entityManager;
    private EntityRepository $countryRepository;
    private CountryFactory $countryFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        $projectDir,
        CountryFactory $countryFactory
    ) {
        $this->entityManager = $entityManager;
        $this->projectDir = $projectDir;
        $this->countryRepository = $this->entityManager->getRepository(Country::class);
        $this->countryFactory = $countryFactory;
    }


    /**
     * @param string $fileName
     * @return bool
     */
    public function convertCsvToCountry(string $fileName): bool
    {
        $inputFile = $this->projectDir . '/src/Utils/' . $fileName;
        $decoder = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        $rows = $decoder->decode(file_get_contents($inputFile), 'csv');

        foreach ($rows as $row) {
            if ($row['Abbreviation'] and $row['Name']) {
                $hasCountryInserted = $this->countryRepository->findOneBy(
                    [
                            'name' => $row['Name'],
                            'abbreviation' => $row['Abbreviation']
                        ]
                );

                if ($hasCountryInserted) {
                    continue;
                }
                $country = $this->countryFactory->createCountry($row['Name'], $row['Abbreviation']);
                $this->entityManager->persist($country);
            }
        }

        $this->entityManager->flush();

        return true;
    }

    public function exportToCsv($sorter)
    {
        $countries = $this->countryRepository->findBy([], [$sorter => 'ASC']);
        $fileName = 'country-csv-' . date('Y-m-d-H-i-s') . '.csv';
        $path = $this->projectDir . '/public/exports/' . $fileName;
        $handle = fopen($path, 'w');

        /**
         * @param $country Country
         */
        foreach ($countries as $country) {
            fputcsv(
                $handle,
                [$country->getName(), $country->getAbbreviation()]
            );
        }
        fclose($handle);

        if (file_exists($path)) {
            return ['path' => $path, 'name' => $fileName];
        } else {
            return false;
        }
    }
}
