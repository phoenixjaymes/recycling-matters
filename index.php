<?php
/* 
 * File Name: index.php
 * Date: 28 Jun 16
 * Programmer: Jaymes Young-Liebgott
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/vendor/autoload.php';

$settings =  [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$app = new \Slim\App($settings);

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($c) {    
    $view = new \Slim\Views\Twig('assets/views/', [
        'cache' => false
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));
    return $view;
};

// Render template in route
$app->get('/', function ($request, $response, $test) {
    $this->view->render($response, 'index.twig', ['pageName' => 'home']);
})->setName('home');

$app->get('/reduce', function ($request, $response) {
    $this->view->render($response, 'reduce.twig', ['pageName' => 'reduce']);
})->setName('reduce');

$app->get('/reuse', function ($request, $response) {
    $this->view->render($response, 'reuse.twig', ['pageName' => 'reuse']);
})->setName('reuse');

$app->get('/recycle', function ($request, $response) {
    $this->view->render($response, 'recycle.twig', ['pageName' => 'recycle']);
})->setName('recycle');

$app->get('/quiz', function ($request, $response) {
    $this->view->render($response, 'quiz.twig', ['pageName' => 'quiz']);
})->setName('quiz');

// Run app
$app->run();