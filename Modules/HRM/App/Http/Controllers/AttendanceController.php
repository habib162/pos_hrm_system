<?php
namespace Modules\HRM\App\Http\Controllers;
use App\Http\Controllers\Controller;
class AttendanceController extends Controller {
    public function index() { return view('hrm::attendances.index'); }
    public function create() { return view('hrm::attendances.create'); }
    public function store() {}
    public function show($id) { return view('hrm::attendances.show'); }
    public function edit($id) { return view('hrm::attendances.edit'); }
    public function update($id) {}
    public function destroy($id) {}
}
