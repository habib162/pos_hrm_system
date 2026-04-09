<?php

namespace Modules\POS\App\Http\Controllers;

use App\Http\Controllers\Controller;

class POSTerminalController extends Controller
{
    public function __invoke()
    {
        return view('pos::terminal.index');
    }
}
