<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Reservation, Invoice, Expense, Promotion};

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'reservas_proximas' => Reservation::whereDate('start_at', '>=', now())
                                              ->orderBy('start_at')
                                              ->limit(5)
                                              ->get(),

            'ingresos_mes'     => Invoice::whereMonth('created_at', now()->month)->sum('total'),

            'gastos_mes'       => Expense::whereMonth('created_at', now()->month)->sum('amount'),

            // 🔥 ARREGLADO - SIN is_active
            'promociones_activas' => Promotion::get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
