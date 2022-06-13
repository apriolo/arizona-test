<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

abstract class ApiController extends AbstractController
{
    abstract public function index(Request $request);
    abstract public function create(Request $request);
    abstract public function show(int $id, Request $request);
    abstract public function delete(int $id, Request $request);
    abstract public function update(int $id, Request $request);
}
