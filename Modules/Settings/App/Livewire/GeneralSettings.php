<?php

namespace Modules\Settings\App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Modules\Settings\App\Entities\Setting;

class GeneralSettings extends Component
{
    use WithFileUploads;

    public string $activeTab = 'company';

    /** All settings keyed by key => value */
    public array $settings = [];

    /** Temporary logo upload */
    public $logo;

    /** Toast message */
    public ?string $successMessage = null;

    public function mount(): void
    {
        $this->loadSettings();
    }

    private function loadSettings(): void
    {
        $this->settings = Setting::pluck('value', 'key')->toArray();
    }

    /**
     * Save all settings in the active group.
     */
    public function saveGroup(string $group): void
    {
        $groupSettings = Setting::where('group', $group)->pluck('key')->toArray();

        foreach ($groupSettings as $key) {
            if (array_key_exists($key, $this->settings)) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $this->settings[$key]]
                );
            }
        }

        // Cache is busted by Setting::saved() boot hook
        $this->successMessage = ucfirst($group) . ' settings saved successfully!';
        $this->dispatch('toast-success', message: $this->successMessage);
    }

    /**
     * Handle logo upload and save to storage.
     */
    public function uploadLogo(): void
    {
        $this->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        Storage::disk('public')->makeDirectory('logos');
        $path = $this->logo->store('logos', 'public');

        Setting::set('company_logo', $path);
        $this->settings['company_logo'] = $path;
        $this->logo = null;

        $this->successMessage = 'Logo uploaded successfully!';
        $this->dispatch('toast-success', message: $this->successMessage);
    }

    /**
     * Reset success message when tab changes.
     */
    public function updatedActiveTab(): void
    {
        $this->successMessage = null;
        $this->logo = null;
    }

    public function render()
    {
        $groups = Setting::select('group')->distinct()->pluck('group')->toArray();

        $settingsByGroup = [];
        foreach (['company', 'pos', 'hrm', 'system'] as $group) {
            $settingsByGroup[$group] = Setting::where('group', $group)->orderBy('id')->get();
        }

        return view('settings::livewire.general-settings', compact('settingsByGroup'))
            ->layout('core::layouts.app')
            ->title('Settings');
    }
}
