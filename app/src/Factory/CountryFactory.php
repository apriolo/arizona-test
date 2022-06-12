<?php

namespace App\Factory;

use App\Entity\Country;

class CountryFactory
{

    /**
     * @param string $name
     * @param string $abbreviation
     * @return Country
     */
    public function createCountry(string $name, string $abbreviation): Country
    {
        $country = new Country();
        $country->setAbbreviation($abbreviation);
        $country->setName($name);
        return $country;
    }
}