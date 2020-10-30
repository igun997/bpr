<?php

use Jenssegers\Blade\Blade;
class Blade_helper
{
    public $init;
    public function __construct()
    {
        $this->init = new Blade(APPPATH.'views',APPPATH.'cache');
    }

    public function view($path,$data = [])
    {
        echo $this->init->make($path, $data)->render();
    }
}