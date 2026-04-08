<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalPackages = packages::where('is_active', true)->count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('amount_paid');

        // Data Chart Status Pembayaran (Global)
        $paymentStatusData = Transaction::select('payment_status', DB::raw('count(*) as count'))
            ->groupBy('payment_status')
            ->get()
            ->pluck('count', 'payment_status')
            ->toArray();

        // Data Chart Transaksi Bulanan (Tahun Berjalan)
        $currentYear = date('Y');
        $monthlyData = Transaction::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('count(*) as count')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        
        $monthlyTransactions = [];
        foreach ($monthNames as $num => $name) {
            $monthlyTransactions[$name] = $monthlyData[$num] ?? 0;
        }

        return view('Admin.Dashboard', compact(
            'totalUsers',
            'totalPackages',
            'totalTransactions',
            'totalRevenue',
            'paymentStatusData',
            'monthlyTransactions'
        ));
    }
}
