<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Appointment;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalServices'      => Service::count(),
            'totalAppointments'  => Appointment::count(),
            'paidPayments'       => Payment::where('status', 'paid')->count(),
            'unpaidPayments'     => Payment::where('status', 'unpaid')->count(),
            'recentAppointments' => Appointment::with(['service', 'payment'])->latest()->take(5)->get(),
            'services'           => Service::latest()->take(5)->get(),
        ]);
    }
}
