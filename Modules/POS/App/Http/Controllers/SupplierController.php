<?php
namespace Modules\POS\App\Http\Controllers;
use App\Http\Controllers\Controller;
class SupplierController extends Controller {
    public function index() { return view('pos::suppliers.index'); }
    public function create() { return view('pos::suppliers.create'); }
    public function store() {}
    public function edit($id) { return view('pos::suppliers.edit'); }
    public function update($id) {}
    public function destroy($id) {}
}
