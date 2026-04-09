<?php
namespace Modules\HRM\App\Http\Controllers;
use App\Http\Controllers\Controller;
class EmployeeController extends Controller {
    public function index() { return view('hrm::employees.index'); }
    public function create() { return view('hrm::employees.create'); }
    public function store() {}
    public function show($id) { return view('hrm::employees.show'); }
    public function edit($id) { return view('hrm::employees.edit'); }
    public function update($id) {}
    public function destroy($id) {}
}
