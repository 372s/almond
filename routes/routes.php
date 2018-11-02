<?php
use Bootstrap\Router;

Router::get('/', 'HomeController@home');
Router::get('/sohu', 'HomeController@sohu');

Router::dispatch();
// function dispatch()
// {
//
// }
//
// register_shutdown_function('dispatch');