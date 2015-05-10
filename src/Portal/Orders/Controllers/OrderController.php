<?php
namespace Portal\Orders\Controllers;

use IlluminateExtensions\Routing\Controller;
use Portal\Companies\Models\Company;

class OrderController extends Controller {

    public function showCompanyOrders(Company $company)
    {

        return $this->view('orders.view.index', [
            'orders' => $company->orders()->with('product')->paginate(15),
        ]);
    }

}
