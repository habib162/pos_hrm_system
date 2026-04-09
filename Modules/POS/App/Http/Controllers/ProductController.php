<?php

namespace Modules\POS\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\POS\App\Entities\Product;

class ProductController extends Controller
{
    public function index()
    {
        return view('pos::products.index');
    }

    public function create()
    {
        return view('pos::products.form');
    }

    public function edit(Product $product)
    {
        return view('pos::products.form', ['productId' => $product->id]);
    }
}
