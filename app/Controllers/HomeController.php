<?php

/**
* \HomeController
*/

namespace App\Controllers;

use Wpollen\View\View;
use App\Filesystem\Filesystem;
use App\Finder\Finder;
use Nette\Utils\Finder as NFinder;

class HomeController extends BaseController {

    public function home() {
        // return 'Hello Almond!';
        // return View::json(['a' => 'b']);
        return view('home')->with('name', 'Hello Almond!');
    }

    public function test() {
        $path = BASE_PATH . '/config';
        $f = new Filesystem();
        $directories = $f->directories($path);
        var_dump($directories);
    }

    public function finder() {
        $path = BASE_PATH . '/config';
        $iterator = NFinder::findDirectories()->in($path);
        foreach ($iterator as $key => $file) {
            var_dump($key, $file);
        }
    }
}