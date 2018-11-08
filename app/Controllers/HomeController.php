<?php
/**
* \HomeController
*/
namespace App\Controllers;

use Wpollen\View\View;

class HomeController extends BaseController {

    public function home() {
        exit;
        // return 'Hello Almond!';
        // return View::json(['a' => 'b']);
        // return view('home')->with('name', 'wangqiang');
    }

    public function phpQuery() {
        echo 1;
    }
}