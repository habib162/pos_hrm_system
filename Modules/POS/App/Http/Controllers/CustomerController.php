<?php

namespace Modules\POS\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\POS\App\Entities\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        return view('pos::customers.index');
    }

    public function create()
    {
        return view('pos::customers.form');
    }

    public function edit(Customer $customer)
    {
        return view('pos::customers.form', ['customerId' => $customer->id]);
    }
}
