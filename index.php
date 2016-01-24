<?php
// framework/index.php
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

$input = $request->cookies->get('_ga');

$response = new Response(var_dump($input));

$response->send();