<?php
/** @var App\Core\Route $route*/
const API_PREFIX = '/api/';
// Initialize the route instance

// Set the needed headers
$route->setHeaders([
    'Accept' => 'application/json',
    'Content-Type' => 'application/json',
    'Access-Control-Allow-Origin' => '*', // Allow everyone (bad practice, but for the task lets leave it)
    'Access-Control-Allow-Methods' => 'OPTIONS, GET, POST, PATCH, DELETE, PUT',
    'Access-Control-Allow-Headers' => '*'
]);

// Initialize the routes
$route->get(API_PREFIX . 'auth/register', 'Auth', 'register');
$route->get(API_PREFIX . 'auth/login',  'Auth', 'login');
$route->get(API_PREFIX . 'auth/user',  'Auth', 'user');
$route->get(API_PREFIX . 'auth/logout',  'Auth', 'logout');
$route->get(API_PREFIX . 'books', 'Book', 'index');
$route->get(API_PREFIX . 'users', 'User', 'index');
$route->get(API_PREFIX . 'books/show', 'Book', 'show');
$route->get(API_PREFIX . 'books/collect', 'Book', 'userCollection');


$route->post(API_PREFIX . 'auth/register',  'Auth', 'processRegister');
$route->post(API_PREFIX . 'auth/login',  'Auth', 'processLogin');
$route->post(API_PREFIX . 'books', 'Book', 'store');
$route->post(API_PREFIX . 'books/collect', 'Book', 'collect');

$route->put(API_PREFIX . 'auth/user',  'Auth', 'update');
$route->put(API_PREFIX . 'users', 'User', 'update');
$route->put(API_PREFIX . 'books', 'Book', 'update');
$route->delete(API_PREFIX . 'books/collect', 'Book', 'collectDelete');

