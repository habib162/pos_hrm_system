<?php
namespace Modules\HRM\App\Http\Controllers;
use App\Http\Controllers\Controller;
class DepartmentController extends Controller {
    public function index() { return view('hrm::departments.index'); }
    public function create() { return view('hrm::departments.create'); }
    public function store() {}
    public function show($id) { return view('hrm::departments.show'); }
    public function edit($id) { return view('hrm::departments.edit'); }
    public function update($id) {}
    public function destroy($id) {}
}
