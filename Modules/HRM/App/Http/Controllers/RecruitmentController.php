<?php
namespace Modules\HRM\App\Http\Controllers;
use App\Http\Controllers\Controller;
class RecruitmentController extends Controller {
    public function index() { return view('hrm::recruitments.index'); }
    public function create() { return view('hrm::recruitments.create'); }
    public function store() {}
    public function show($id) { return view('hrm::recruitments.show'); }
    public function edit($id) { return view('hrm::recruitments.edit'); }
    public function update($id) {}
    public function destroy($id) {}
}
