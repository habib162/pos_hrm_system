<?php

namespace Modules\Reports\App\Http\Controllers;

use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function posReport()
    {
        return view('reports::pos.index');
    }

    public function hrmReport()
    {
        return view('reports::hrm.index');
    }
}
