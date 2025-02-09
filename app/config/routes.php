<?php

use App\core\Router;
use App\controllers\front\eventController;
use App\controllers\front\userController;
use App\controllers\back\dashboardController;
use App\core\Auth;


$router = new Router();

$router->get('/', eventController::class, 'home');
$router->get('/event', eventController::class, 'event');
$router->get('/event', eventController::class, 'readAll');
// affichage du dashboard pour l'admin
$router->get('/dashboard', dashboardController::class, 'index');

$router->get('/login', userController::class, 'loginPage');
$router->get('/signup', userController::class, 'signupPage');


$router->post('/login', Auth::class, 'login');
$router->post('/signup', userController::class, 'signup');
$router->get('/logout', Auth::class, 'logout');

$router->dispatch();