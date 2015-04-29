<?php namespace Portal\Companies\Controllers;

use Illuminate\Cache\Repository;
use IlluminateExtensions\Routing\Controller;
use Portal\Companies\Models\Company;

class CompanyController extends Controller{

    protected $cache;

    function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }


    public function display(Company $company)
    {
        return $company;
    }

    public function activities(Company $company)
    {
        return $company->activity;
    }

}