<?php

namespace Modules\Settings\App\Http\Controllers;

use App\Http\Controllers\Controller;

class GeneralSettingsController extends Controller
{
    public function __invoke()
    {
        return view('settings::livewire.general-settings-page');
    }
}
