<?php namespace Portal\Users\Controllers\Reports;


use IlluminateExtensions\Routing\Controller;
use Portal\Foundation\Theme\CanChangeThemes;

class SalesReportController extends Controller {
    use CanChangeThemes;

    public function getIndex()
    {
        dd($this->view('hello', []));
    }

}