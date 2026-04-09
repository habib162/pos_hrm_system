<?php
namespace Modules\HRM\App\Http\Controllers;
use App\Http\Controllers\Controller;
class PayrollController extends Controller {
    public function index() { return view('hrm::payrolls.index'); }
    public function create() { return view('hrm::payrolls.create'); }
    public function store() {}
    public function show($id) { return view('hrm::payrolls.show'); }
    public function edit($id) { return view('hrm::payrolls.edit'); }
    public function update($id) {}
    public function destroy($id) {}
}
