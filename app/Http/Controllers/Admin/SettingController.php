<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        // Ambil semua settings
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        // Default values jika belum ada
        $appName = $settings['app_name'] ?? 'KostMudah Management System';
        $appDescription = $settings['app_description'] ?? 'Platform manajemen properti dan manajemen penghuni untuk efisiensi bisnis rumah kos Anda.';
        $adminFee = $settings['admin_fee'] ?? '2500';
        $minWithdrawal = $settings['min_withdrawal'] ?? '50000';
        $emailInvoice = $settings['email_invoice'] ?? 'true';
        $emailReminder = $settings['email_reminder'] ?? 'true';
        $maintenanceMode = $settings['maintenance_mode'] ?? 'false';
        $logo = $settings['app_logo'] ?? null;

        return view('admin.pengaturan.index', compact(
            'appName',
            'appDescription',
            'adminFee',
            'minWithdrawal',
            'emailInvoice',
            'emailReminder',
            'maintenanceMode',
            'logo'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_description' => 'nullable|string|max:500',
            'admin_fee' => 'required|numeric|min:0',
            'min_withdrawal' => 'required|numeric|min:0',
            'email_invoice' => 'required|in:true,false',
            'email_reminder' => 'required|in:true,false',
            'maintenance_mode' => 'required|in:true,false',
        ]);

        // Update settings
        Setting::set('app_name', $request->app_name, 'string', 'general');
        Setting::set('app_description', $request->app_description, 'string', 'general');
        Setting::set('admin_fee', $request->admin_fee, 'number', 'system');
        Setting::set('min_withdrawal', $request->min_withdrawal, 'number', 'system');
        Setting::set('email_invoice', $request->email_invoice, 'boolean', 'notification');
        Setting::set('email_reminder', $request->email_reminder, 'boolean', 'notification');
        Setting::set('maintenance_mode', $request->maintenance_mode, 'boolean', 'system');

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $file = $request->file('logo');
        $fileName = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('settings', $fileName, 'public');

        // Hapus logo lama jika ada
        $oldLogo = Setting::get('app_logo');
        if ($oldLogo && Storage::exists($oldLogo)) {
            Storage::delete($oldLogo);
        }

        Setting::set('app_logo', $path, 'string', 'general');

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Logo berhasil diperbarui.');
    }

    public function removeLogo()
    {
        $oldLogo = Setting::get('app_logo');
        if ($oldLogo && Storage::exists($oldLogo)) {
            Storage::delete($oldLogo);
        }

        Setting::set('app_logo', null, 'string', 'general');

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Logo berhasil dihapus.');
    }
}