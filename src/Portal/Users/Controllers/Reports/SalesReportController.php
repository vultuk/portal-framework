<?php namespace Portal\Users\Controllers\Reports;

use IlluminateExtensions\Routing\Controller;
use Portal\Foundation\Theme\CanChangeThemes;

class SalesReportController extends Controller {

    public function getIndex()
    {
        return $this->view('users.reports.index');
    }

}