<?php namespace Portal\Foundation\Http\Middleware;

use Closure;
use Illuminate\View\View;

class SetsThemePath {

    protected $defaultTheme = 'themes.bootstrap';

    public function handle($request, Closure $next)
    {
        \View::share('theme', $this->defaultTheme);

        return $next($request);
    }

}