<?php

namespace Modules\POS\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\POS\App\Entities\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('pos::categories.index');
    }

    public function create()
    {
        return view('pos::categories.form');
    }

    public function edit(Category $category)
    {
        return view('pos::categories.form', ['categoryId' => $category->id]);
    }
}
