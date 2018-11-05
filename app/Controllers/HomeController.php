<?php
/**
* \HomeController
*/
namespace App\Controllers;

use Bootstrap\View;

class HomeController {

    public function home() {
        // return 'Hello Almond!';
        return view('home')->with('name', 'wangqiang');
    }

    public function phpQuery() {
        echo 1;
    }
}