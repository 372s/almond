<?php

Router::get('/', 'HomeController@home');
Router::get('/test', 'HomeController@test');
Router::get('/finder', 'HomeController@finder');

