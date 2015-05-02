<?php namespace Portal\Foundation\Http\Middleware;

use Closure;
use Illuminate\Contracts\View\Factory as View;

class SetsThemePath {

    protected $defaultTheme = 'portal::themes.bootstrap.';
    protected $defaultPages = 'portal::pages.';

    protected $view;

    function __construct(View $view)
    {
        $this->view = $view;
    }

    public function handle($request, Closure $next)
    {
        $this->view->share('theme', $this->defaultTheme);
        $this->view->share('pages', $this->defaultPages);

        return $next($request);
    }

}
