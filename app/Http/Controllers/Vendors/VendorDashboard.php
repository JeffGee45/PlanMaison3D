<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorDashboard extends Controller
{
    public function index()
    {
        return view('dashboard.vendors.home');
    }

    public function logout (){
        Auth::guard('vendor');
        return redirect()->route('vendors.login');
    }
}
