<?php

namespace App\Controller;

use App\Services\CountryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Stream;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class CountryController extends AbstractController
{
    private CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index(Request $request)
    {
        $sorter = ($request->get('sort')) ?: 'name';
        $countries = $this->countryService->findAllSorting($sorter);
        return $this->render(
            'countries/list.html.twig',
            [
                "countries" => $countries,
                'sorter' => $sorter
            ]
        );
    }
}