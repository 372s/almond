<?php

/**
 * Created by PhpStorm.
 * User: wq455
 * Date: 2018/11/05
 * Time: 23:32
 */

namespace App\Foundation;


class Application
{
    protected $basePath;

    public function __construct($basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }

        // $this->registerBaseBindings();
        //
        // $this->registerBaseServiceProviders();
        //
        // $this->registerCoreContainerAliases();
    }

    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');
    }
}