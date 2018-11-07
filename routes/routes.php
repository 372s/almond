<?php
use Wpollen\Routing\Router;

Router::get('/', 'HomeController@home');
Router::get('/phpQuery', 'HomeController@phpQuery');

