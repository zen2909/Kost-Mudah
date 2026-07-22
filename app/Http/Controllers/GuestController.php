<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BoardingHouse;

class GuestController extends Controller
{
    public function index()
    {
         $popularKosts = BoardingHouse::with(['primaryPhoto', 'user'])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('index', compact('popularKosts'));
    }
}