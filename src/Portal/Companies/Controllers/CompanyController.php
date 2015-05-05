<?php namespace Portal\Companies\Controllers;

use Illuminate\Cache\Repository;
use IlluminateExtensions\Routing\Controller;
use Portal\Companies\Models\Company;

class CompanyController extends Controller{

    protected $cache;

    function __construct(Repository $cache)
    {
        parent::__construct();
        $this->cache = $cache;
    }


    public function index()
    {
        $companies = Company::paginate(15);

        return $this->view('companies.index', [
            'companies' => $companies,
        ]);
    }

    public function display(Company $company)
    {
        return $this->view('companies.view.index', [
            'company' => $company,
        ]);
    }

    public function activities(Company $company)
    {
        return $company->activity;
    }

}
