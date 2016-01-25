<?php
// framework/front.php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;


$request = Request::createFromGlobals();
$routes = include __DIR__.'/../src/app.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);


$generator = new Routing\Generator\UrlGenerator($routes, $context);

// echo $generator->generate(
//     'hello',
//     array('name' => 'Fabien'),
//     Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL
// );die;

// 生成新的路由匹配类
// $dumper = new Routing\Matcher\Dumper\PhpMatcherDumper($routes);

// echo $dumper->dump();die;

try {
    extract($matcher->match($request->getPathInfo()), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);

    $response = new Response(ob_get_clean());
} catch (Routing\Exception\ResourceNotFoundException $e) {
    $response = new Response('Not Found', 404);
} catch (Exception $e) {
    $response = new Response('An error occurred', 500);
}

$response->send();