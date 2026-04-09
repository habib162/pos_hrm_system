<?php
namespace Modules\HRM\App\Http\Controllers;
use App\Http\Controllers\Controller;
use Modules\HRM\App\Entities\Leave;
class LeaveController extends Controller {
    public function index() { return view('hrm::leaves.index'); }
    public function create() { return view('hrm::leaves.create'); }
    public function store() {}
    public function approve(Leave $leave) {
        $leave->update(['status' => 'approved', 'approved_by' => auth()->id(), 'approved_at' => now()]);
        return back()->with('success', 'Leave approved.');
    }
    public function reject(Leave $leave) {
        $leave->update(['status' => 'rejected', 'approved_by' => auth()->id(), 'approved_at' => now()]);
        return back()->with('success', 'Leave rejected.');
    }
}
