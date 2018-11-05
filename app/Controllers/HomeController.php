<?php
/**
* \HomeController
*/
namespace App\Controllers;

use Bootstrap\View;

class HomeController extends BaseController {

    public function home() {
        // return 'Hello Almond!';
        return json(['a' => 'b']);
        return view('home')->with('name', 'wangqiang');
    }

    public function phpQuery() {
        echo 1;
    }
}