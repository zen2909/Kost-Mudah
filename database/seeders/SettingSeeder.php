<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('app_name', 'KostMudah Management System', 'string', 'general');
        Setting::set('app_description', 'Platform manajemen properti dan manajemen penghuni untuk efisiensi bisnis rumah kos Anda.', 'string', 'general');
        Setting::set('admin_fee', '2500', 'number', 'system');
        Setting::set('min_withdrawal', '50000', 'number', 'system');
        Setting::set('email_invoice', 'true', 'boolean', 'notification');
        Setting::set('email_reminder', 'true', 'boolean', 'notification');
        Setting::set('maintenance_mode', 'false', 'boolean', 'system');
    }
}