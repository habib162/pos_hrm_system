<div x-data="{ toast: false, toastMsg: '' }"
     x-on:toast-success.window="toast = true; toastMsg = $event.detail.message; setTimeout(() => toast = false, 3500)">

    {{-- ── Page Header ─────────────────────────────────────────── --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">System Settings</h2>
            <p class="text-sm text-gray-500 mt-0.5">Configure your POS & HRM system preferences</p>
        </div>
        <div class="text-sm text-gray-400">
            <span class="font-medium text-indigo-600">{{ setting('company_name', 'My Business') }}</span>
        </div>
    </div>

    {{-- ── Toast Notification ───────────────────────────────────── --}}
    <div x-show="toast"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-end="opacity-0"
         class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-green-600 text-white px-5 py-3 rounded-xl shadow-lg">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span x-text="toastMsg" class="text-sm font-medium"></span>
    </div>

    {{-- ── Tab Bar ─────────────────────────────────────────────── --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="flex border-b border-gray-200">
            @foreach(['company' => ['label' => 'Company', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                       'pos'     => ['label' => 'POS',     'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                       'hrm'     => ['label' => 'HRM',     'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                       'system'  => ['label' => 'System',  'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z']]
            as $tab => $meta)
            <button wire:click="$set('activeTab', '{{ $tab }}')"
                    class="flex items-center gap-2 px-5 py-4 text-sm font-medium transition-colors border-b-2
                        {{ $activeTab === $tab
                            ? 'border-indigo-600 text-indigo-600 bg-indigo-50/40'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $meta['icon'] }}"/>
                </svg>
                {{ $meta['label'] }}
            </button>
            @endforeach
        </div>

        <div class="p-6">

            {{-- ╔══════════════════════════════════╗ --}}
            {{-- ║         COMPANY TAB              ║ --}}
            {{-- ╚══════════════════════════════════╝ --}}
            @if($activeTab === 'company')
            <div>
                <h3 class="text-base font-semibold text-gray-800 mb-5">Company Information</h3>

                {{-- Logo Upload --}}
                <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Company Logo</label>
                    <div class="flex items-start gap-5">
                        {{-- Current Logo Preview --}}
                        <div class="w-20 h-20 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden bg-white">
                            @if(!empty($settings['company_logo']))
                                <img src="{{ Storage::url($settings['company_logo']) }}"
                                     alt="Company Logo"
                                     class="w-full h-full object-contain p-1">
                            @else
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            {{-- Live Preview --}}
                            @if($logo)
                            <div class="mb-3">
                                <p class="text-xs text-gray-500 mb-1">Preview:</p>
                                <img src="{{ $logo->temporaryUrl() }}"
                                     class="h-16 rounded-lg border border-gray-200 object-contain bg-white p-1">
                            </div>
                            @endif
                            <div class="flex items-center gap-3">
                                <input type="file" wire:model="logo" accept="image/*"
                                       class="block text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"/>
                                @if($logo)
                                <button wire:click="uploadLogo"
                                        wire:loading.attr="disabled"
                                        class="px-3 py-1.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition disabled:opacity-50">
                                    <span wire:loading.remove wire:target="uploadLogo">Upload</span>
                                    <span wire:loading wire:target="uploadLogo">Uploading...</span>
                                </button>
                                @endif
                            </div>
                            <p class="text-xs text-gray-400 mt-1.5">PNG, JPG or WebP — max 2MB</p>
                            @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Company Fields --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    @foreach($settingsByGroup['company'] as $s)
                        @if($s->type !== 'image')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                {{ $s->label }}
                                @if($s->description)
                                <span class="text-xs text-gray-400 font-normal">({{ $s->description }})</span>
                                @endif
                            </label>
                            <input type="text"
                                   wire:model="settings.{{ $s->key }}"
                                   placeholder="{{ setting($s->key, '') }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"/>
                        </div>
                        @endif
                    @endforeach
                </div>

                <div class="flex justify-end pt-2 border-t border-gray-100">
                    <button wire:click="saveGroup('company')"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 active:scale-95 transition disabled:opacity-60">
                        <span wire:loading.remove wire:target="saveGroup('company')">
                            <svg class="w-4 h-4 inline -mt-0.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Save Company Settings
                        </span>
                        <span wire:loading wire:target="saveGroup('company')">Saving...</span>
                    </button>
                </div>
            </div>
            @endif

            {{-- ╔══════════════════════════════════╗ --}}
            {{-- ║           POS TAB                ║ --}}
            {{-- ╚══════════════════════════════════╝ --}}
            @if($activeTab === 'pos')
            <div>
                <h3 class="text-base font-semibold text-gray-800 mb-5">Point of Sale Settings</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    @foreach($settingsByGroup['pos'] as $s)
                    <div @if($s->key === 'receipt_footer') class="md:col-span-2" @endif>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            {{ $s->label }}
                        </label>
                        @if($s->key === 'receipt_footer')
                        <textarea wire:model="settings.{{ $s->key }}" rows="2"
                                  placeholder="{{ setting($s->key, '') }}"
                                  class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        @elseif($s->type === 'number')
                        <div class="relative">
                            <input type="number"
                                   wire:model="settings.{{ $s->key }}"
                                   placeholder="{{ setting($s->key, '0') }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10"/>
                            @if($s->key === 'tax_percentage')
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">%</span>
                            @endif
                        </div>
                        @else
                        <div class="relative">
                            @if($s->key === 'currency_symbol')
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">
                                {{ setting('currency_symbol', '৳') }}
                            </span>
                            @endif
                            <input type="text"
                                   wire:model="settings.{{ $s->key }}"
                                   placeholder="{{ setting($s->key, '') }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $s->key === 'currency_symbol' ? 'pl-8' : '' }}"/>
                        </div>
                        @endif
                        @error('settings.'.$s->key)
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @endforeach
                </div>

                {{-- POS Preview Card --}}
                <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Preview</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <div class="flex justify-between">
                            <span>Currency:</span>
                            <span class="font-medium">{{ $settings['currency_symbol'] ?? '৳' }} ({{ $settings['currency_code'] ?? 'BDT' }})</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Tax Rate:</span>
                            <span class="font-medium">{{ $settings['tax_percentage'] ?? '0' }}%</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Low Stock Alert:</span>
                            <span class="font-medium text-orange-600">≤ {{ $settings['low_stock_alert'] ?? '10' }} units</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-2 border-t border-gray-100">
                    <button wire:click="saveGroup('pos')"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 active:scale-95 transition disabled:opacity-60">
                        <span wire:loading.remove wire:target="saveGroup('pos')">Save POS Settings</span>
                        <span wire:loading wire:target="saveGroup('pos')">Saving...</span>
                    </button>
                </div>
            </div>
            @endif

            {{-- ╔══════════════════════════════════╗ --}}
            {{-- ║           HRM TAB                ║ --}}
            {{-- ╚══════════════════════════════════╝ --}}
            @if($activeTab === 'hrm')
            <div>
                <h3 class="text-base font-semibold text-gray-800 mb-5">HRM Settings</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    @foreach($settingsByGroup['hrm'] as $s)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            {{ $s->label }}
                        </label>
                        @if($s->type === 'number')
                        <div class="relative">
                            <input type="number"
                                   wire:model="settings.{{ $s->key }}"
                                   placeholder="{{ setting($s->key, '0') }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500
                                       {{ in_array($s->key, ['late_mark_after']) ? 'pr-16' : '' }}"/>
                            @if($s->key === 'late_mark_after')
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">mins</span>
                            @elseif($s->key === 'salary_date')
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">of month</span>
                            @endif
                        </div>
                        @else
                        <input type="time"
                               wire:model="settings.{{ $s->key }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"/>
                        @endif
                    </div>
                    @endforeach
                </div>

                {{-- Work Hours Preview --}}
                <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Work Schedule Preview</p>
                    <div class="flex items-center gap-3 text-sm">
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg font-medium">
                            {{ $settings['work_start_time'] ?? '09:00' }}
                        </span>
                        <span class="text-gray-400">→</span>
                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg font-medium">
                            {{ $settings['work_end_time'] ?? '18:00' }}
                        </span>
                        <span class="text-gray-500 ml-2">
                            Late after {{ $settings['late_mark_after'] ?? '15' }} mins |
                            Salary on day {{ $settings['salary_date'] ?? '1' }}
                        </span>
                    </div>
                </div>

                <div class="flex justify-end pt-2 border-t border-gray-100">
                    <button wire:click="saveGroup('hrm')"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 active:scale-95 transition disabled:opacity-60">
                        <span wire:loading.remove wire:target="saveGroup('hrm')">Save HRM Settings</span>
                        <span wire:loading wire:target="saveGroup('hrm')">Saving...</span>
                    </button>
                </div>
            </div>
            @endif

            {{-- ╔══════════════════════════════════╗ --}}
            {{-- ║         SYSTEM TAB               ║ --}}
            {{-- ╚══════════════════════════════════╝ --}}
            @if($activeTab === 'system')
            <div>
                <h3 class="text-base font-semibold text-gray-800 mb-5">System Settings</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                    {{-- Date Format --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Date Format</label>
                        <select wire:model="settings.date_format"
                                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="d/m/Y">DD/MM/YYYY ({{ now()->format('d/m/Y') }})</option>
                            <option value="m/d/Y">MM/DD/YYYY ({{ now()->format('m/d/Y') }})</option>
                            <option value="Y-m-d">YYYY-MM-DD ({{ now()->format('Y-m-d') }})</option>
                            <option value="d M Y">DD Mon YYYY ({{ now()->format('d M Y') }})</option>
                        </select>
                    </div>

                    {{-- Timezone --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Timezone</label>
                        <select wire:model="settings.timezone"
                                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach([
                                'Asia/Dhaka'      => 'Asia/Dhaka (UTC+6)',
                                'UTC'             => 'UTC (UTC+0)',
                                'Asia/Kolkata'    => 'Asia/Kolkata (UTC+5:30)',
                                'Asia/Dubai'      => 'Asia/Dubai (UTC+4)',
                                'Asia/Singapore'  => 'Asia/Singapore (UTC+8)',
                                'Europe/London'   => 'Europe/London (UTC+0/+1)',
                                'America/New_York'=> 'America/New_York (UTC-5/-4)',
                            ] as $tz => $label)
                            <option value="{{ $tz }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Items Per Page --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Items Per Page</label>
                        <select wire:model="settings.items_per_page"
                                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach(['10', '15', '25', '50', '100'] as $n)
                            <option value="{{ $n }}">{{ $n }} rows</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                {{-- Current System Info --}}
                <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">System Info</p>
                    <div class="grid grid-cols-2 gap-y-1 text-sm text-gray-600">
                        <span>Laravel Version:</span><span class="font-medium">{{ app()->version() }}</span>
                        <span>PHP Version:</span><span class="font-medium">{{ PHP_VERSION }}</span>
                        <span>App Environment:</span>
                        <span><span class="px-2 py-0.5 text-xs rounded-full {{ config('app.env') === 'production' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ config('app.env') }}</span></span>
                        <span>Debug Mode:</span>
                        <span class="{{ config('app.debug') ? 'text-red-500' : 'text-green-600' }} font-medium">
                            {{ config('app.debug') ? 'ON (disable in production!)' : 'OFF' }}
                        </span>
                    </div>
                </div>

                <div class="flex justify-end pt-2 border-t border-gray-100">
                    <button wire:click="saveGroup('system')"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 active:scale-95 transition disabled:opacity-60">
                        <span wire:loading.remove wire:target="saveGroup('system')">Save System Settings</span>
                        <span wire:loading wire:target="saveGroup('system')">Saving...</span>
                    </button>
                </div>
            </div>
            @endif

        </div>{{-- /p-6 --}}
    </div>{{-- /bg-white --}}

</div>
