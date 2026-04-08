<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();

        $totalTransactions = Transaction::where('user_id', $userId)->count();
        $totalRevenue = Transaction::where('user_id', $userId)->sum('amount_paid');

        // Data Chart Status Pembayaran (Personal)
        $paymentStatusData = Transaction::where('user_id', $userId)
            ->select('payment_status', DB::raw('count(*) as count'))
            ->groupBy('payment_status')
            ->get()
            ->pluck('count', 'payment_status')
            ->toArray();

        // Data Chart Transaksi Bulanan (Tahun Berjalan - Personal)
        $currentYear = date('Y');
        $monthlyData = Transaction::where('user_id', $userId)
            ->select(
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

        return view('Kasir.dashboard', compact(
            'totalTransactions',
            'totalRevenue',
            'paymentStatusData',
            'monthlyTransactions'
        ));
    }
}
