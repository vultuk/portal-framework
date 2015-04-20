<?php namespace IlluminateExtensions\Routing;

abstract class Controller extends ExtendedController {

    public function __construct()
    {
        print "I am Extended";
    }

}