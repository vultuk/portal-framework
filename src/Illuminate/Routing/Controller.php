<?php namespace IlluminateExtensions\Routing;

use Illuminate\Routing\Controller as IlluminateController;

abstract class Controller extends IlluminateController
{

    protected $defaultPageDirectory = 'portal::pages.';

    function __construct()
    {
        $this->middleware('\Portal\Foundation\Http\Middleware\SetsThemePath');
    }

    protected function view($pageName, $vars = [])
    {
        return view($this->defaultPageDirectory . $pageName)->with($vars);
    }
}