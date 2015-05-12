<?php namespace Portal\Companies\Controllers;

use Illuminate\Cache\Repository;
use IlluminateExtensions\Routing\Controller;
use Portal\Companies\Contracts\CompaniesRepository;
use Portal\Companies\Models\Company;
use Portal\Companies\Requests\AddNewAddress;
use Portal\ContactDetails\Models\Address;
use Portal\ContactDetails\Models\Country;

class CompanyController extends Controller{

    protected $cache;

    public function __construct(CompaniesRepository $cache)
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
            'countries' => Country::all(),
        ]);
    }

    public function activities(Company $company)
    {
        return $company->activity;
    }

    public function edit(Company $company)
    {
        dd($company->toArray());
    }

    public function addAddress(Company $company, AddNewAddress $request)
    {
        /*$company->addresses()->save(new Address([
            'description' => $request->description,
            'is_primary' => $request->has('is_primary'),
            'address1' => $request->address1,
            'address2' => $request->address2,
            'town_city' => $request->town,
        ]));*/

        dd($request->all());
    }

}
