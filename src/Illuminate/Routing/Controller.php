<?php namespace IlluminateExtensions\Routing;

use Illuminate\Routing\Controller as IlluminateController;

abstract class Controller extends IlluminateController
{

    protected $defaultTheme = 'bootstrap';

    function __construct()
    {
        $this->middleware('\Portal\Foundation\Http\Middleware\SetsThemePath');
    }
}