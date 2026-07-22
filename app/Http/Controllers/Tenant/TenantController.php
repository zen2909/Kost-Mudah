<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;

class TenantController extends Controller
{
    public function index()
    {
        return view('tenant.index');
    }
    public function kost()
    {
        return view('tenant.kost.index');
    }
    public function favorit()
    {
        return view('tenant.favorit.index');
    }
    public function riwayat()
    {
        return view('tenant.riwayat.index');
    }
    public function profile()
    {
        return view('tenant.profile.index');
    }
    public function detailKost()
    {
        return view('tenant.kost.show');
    }
    public function booking()
    {
        return view('tenant.booking.index');
    }
    public function payment()
    {
        return view('tenant.payment.index');
    }
    public function invoice()
    {
        return view('tenant.invoice.index');
    }
    }