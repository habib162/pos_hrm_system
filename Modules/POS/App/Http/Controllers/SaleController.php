<?php

namespace Modules\POS\App\Http\Controllers;

use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    public function index()
    {
        return view('pos::sales.index');
    }
}
