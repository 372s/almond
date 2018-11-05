<?php
use Bootstrap\Router;

Router::get('/', 'HomeController@home');
Router::get('/phpQuery', 'HomeController@phpQuery');

