<?php namespace Portal\Companies\Controllers;

use Illuminate\Cache\Repository;
use IlluminateExtensions\Routing\Controller;
use Portal\Companies\Models\Company;

class AddressController extends Controller{

    protected $cache;

    public function __construct(Repository $cache)
    {
        parent::__construct();
        $this->cache = $cache;
    }

    public function create(Company $company)
    {
        dd($company->toArray());
    }

}
