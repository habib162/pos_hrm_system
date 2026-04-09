<?php

namespace Modules\Settings\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Settings\App\Entities\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ── Company ──────────────────────────────────────────────
            ['key' => 'company_name',    'value' => 'My Business', 'type' => 'text',   'group' => 'company', 'label' => 'Company name'],
            ['key' => 'company_email',   'value' => '',            'type' => 'text',   'group' => 'company', 'label' => 'Company email'],
            ['key' => 'company_phone',   'value' => '',            'type' => 'text',   'group' => 'company', 'label' => 'Company phone'],
            ['key' => 'company_address', 'value' => '',            'type' => 'text',   'group' => 'company', 'label' => 'Company address'],
            ['key' => 'company_logo',    'value' => '',            'type' => 'image',  'group' => 'company', 'label' => 'Company logo'],

            // ── POS ──────────────────────────────────────────────────
            ['key' => 'currency_symbol', 'value' => '৳',           'type' => 'text',   'group' => 'pos', 'label' => 'Currency symbol'],
            ['key' => 'currency_code',   'value' => 'BDT',         'type' => 'text',   'group' => 'pos', 'label' => 'Currency code'],
            ['key' => 'tax_percentage',  'value' => '0',           'type' => 'number', 'group' => 'pos', 'label' => 'Tax percentage'],
            ['key' => 'receipt_footer',  'value' => 'Thank you!',  'type' => 'text',   'group' => 'pos', 'label' => 'Receipt footer'],
            ['key' => 'low_stock_alert', 'value' => '10',          'type' => 'number', 'group' => 'pos', 'label' => 'Low stock alert qty'],

            // ── HRM ──────────────────────────────────────────────────
            ['key' => 'work_start_time', 'value' => '09:00', 'type' => 'text',   'group' => 'hrm', 'label' => 'Work start time'],
            ['key' => 'work_end_time',   'value' => '18:00', 'type' => 'text',   'group' => 'hrm', 'label' => 'Work end time'],
            ['key' => 'late_mark_after', 'value' => '15',    'type' => 'number', 'group' => 'hrm', 'label' => 'Late mark after (mins)'],
            ['key' => 'salary_date',     'value' => '1',     'type' => 'number', 'group' => 'hrm', 'label' => 'Salary payment date'],

            // ── System ───────────────────────────────────────────────
            ['key' => 'date_format',    'value' => 'd/m/Y',      'type' => 'text',   'group' => 'system', 'label' => 'Date format'],
            ['key' => 'timezone',       'value' => 'Asia/Dhaka', 'type' => 'text',   'group' => 'system', 'label' => 'Timezone'],
            ['key' => 'items_per_page', 'value' => '15',         'type' => 'number', 'group' => 'system', 'label' => 'Items per page'],
        ];

        foreach ($settings as $data) {
            Setting::updateOrCreate(
                ['key' => $data['key']],
                $data
            );
        }

        $this->command->info('✓ Settings seeded: ' . count($settings) . ' entries.');
    }
}
