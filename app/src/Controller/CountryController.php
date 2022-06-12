<?php

namespace App\Controller;

use App\Services\CountryCsvService;
use App\Services\CountryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Stream;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class CountryController extends AbstractController
{
    private CountryService $countryService;
    private CountryCsvService $countryCsvService;

    public function __construct(CountryService $countryService, CountryCsvService $countryCsvService)
    {
        $this->countryService = $countryService;
        $this->countryCsvService = $countryCsvService;
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

    public function exportCsv(Request $request)
    {
        $sorter = ($request->get('sort')) ?: 'name';
        $file = $this->countryCsvService->exportToCsv($sorter);

        $stream = new Stream($file['path']);
        $response = new BinaryFileResponse($stream);
        $response->headers->set('Content-Type', 'text/csv');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $file['name']
        );

        return $response;
    }
}