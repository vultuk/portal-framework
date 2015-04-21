<?php namespace Portal\Foundation\Theme;

use \View as View;

trait CanChangeThemes
{

    protected $defaultTheme = 'portal.default.';

    protected function view($page, $vars = [])
    {
        return View::make($this->getTheme() . $page, $vars);
    }

    protected function getTheme()
    {
        return $this->defaultTheme;
    }

}