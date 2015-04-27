<?php namespace Portal\Companies\Controllers;

use IlluminateExtensions\Routing\Controller;
use Portal\Companies\Models\Company;

class CompanyController extends Controller{

    public function display(Company $company)
    {
        dd($company->toArray());
    }

    public function activities(Company $company)
    {
        return $company->activity;
    }

}