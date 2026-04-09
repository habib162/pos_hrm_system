<?php

namespace Modules\Settings\App\Http\Controllers;

use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function general()
    {
        return view('settings::livewire.general-settings-page');
    }

    public function users()
    {
        return view('settings::users.index');
    }

    public function roles()
    {
        return view('settings::roles.index');
    }
}
