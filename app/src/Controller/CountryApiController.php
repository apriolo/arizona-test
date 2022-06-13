<?php

namespace App\Controller;

use App\Services\CountryApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CountryApiController extends ApiController
{
    private CountryApiService $countryApiService;

    public function __construct(CountryApiService $countryApiService)
    {
        $this->countryApiService = $countryApiService;
    }

    /**
     * Description - Function to get a list of countries
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $sorter = ($request->get('sort')) ?: 'name';
        $countries = $this->countryApiService->findAllSorting($sorter);

        return $this->json(
            [
                'data' => $countries
            ],
            200,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Description - Function to create a new country
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        if (!$name = $request->get('name')) {
            $errors[] = 'The name field is required';
        }

        if (!$abbreviation = $request->get('abbreviation')) {
            $errors[] = 'The Abbreviation field is required';
        }

        if (isset($errors)) {
            return $this->json(
                [
                    'data' => $errors
                ],
                400,
                ['Content-Type' => 'application/json']
            );
        }

        $country = $this->countryApiService->createCountry($name, $abbreviation);

        if ($country == true) {
            $message = 'Country created';
            $code = 200;
        } else {
            $message = 'Error creating country!';
            $code = 400;
        }


        return $this->json(
            [
                'data' => $message
            ],
            $code,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Description - Function to get one country by id
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function show(int $id, Request $request): Response
    {
        if ($country = $this->countryApiService->find($id)) {
            $data = $country;
            $code = 200;
        } else {
            $data = 'Country not found';
            $code = 404;
        }

        return $this->json(
            [
                'data' => $data
            ],
            $code,
            ['Content-Type' => 'application/json']
        );
    }


    /**
     * Description - Function to delete a country by id
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function delete(int $id, Request $request): Response
    {
        if ($country = $this->countryApiService->find($id)) {
            $this->countryApiService->deleteCountry($country);
            $data = 'Country deleted';
            $code = 204;
        } else {
            $data = 'Country not found';
            $code = 404;
        }

        return $this->json(
            [
                'data' => $data
            ],
            $code,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Description - Function to update a country
     * @param int $id
     * @param Request $request
     * @return void
     */
    public function update(int $id, Request $request): Response
    {
        if (!$country = $this->countryApiService->find($id)) {
            $response = 'Country not found';
            $code = 404;
        } else {
            $data = $request->request->all();
            $update = $this->countryApiService->updateCountry($country, $data);
            if ($update) {
                $response = 'Country update success';
                $code = 204;
            } else {
                $response = 'Update Failure';
                $code = 400;
            }
        }

        return $this->json(
            [
                'data' => $response
            ],
            $code,
            ['Content-Type' => 'application/json']
        );
    }
}
