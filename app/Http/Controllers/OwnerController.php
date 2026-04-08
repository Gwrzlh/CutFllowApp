<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\packages;
use App\Models\photographer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('amount_paid');

        // Data Chart Status Pembayaran
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

        // Siapkan array 1-12 untuk memastikan semua bulan ada
        $monthlyTransactions = [];
        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        foreach ($monthNames as $num => $name) {
            $monthlyTransactions[$name] = $monthlyData[$num] ?? 0;
        }

        return view('Owner.Dashboard', compact(
            'totalTransactions', 
            'totalRevenue', 
            'paymentStatusData', 
            'monthlyTransactions'
        ));
    }

    public function transactionAudit(Request $request)
    {
        $query = Transaction::with(['package', 'photographer', 'user']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'LIKE', "%{$search}%")
                  ->orWhere('customer_name', 'LIKE', "%{$search}%");
            });
        }

        // Date Range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('Owner.TransactionAudit', compact('transactions'));
    }

    public function usersAudit(Request $request)
    {
        $query = User::with('role');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->paginate(10);

        return view('Owner.UsersAudit', compact('users'));
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = ($user->status === 'active') ? 'inactive' : 'active';
        $user->save();

        return back()->with('success', "Status user {$user->name} berhasil diubah menjadi {$user->status}");
    }

    public function auditAssetsPackages(Request $request)
    {
        $query = packages::withCount('Transaction');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $packages = $query->paginate(10);

        return view('Owner.AuditAssets.packages', compact('packages'));
    }

    public function auditAssetsPhotographer(Request $request)
    {
        $query = photographer::withCount('Transaction');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $photographers = $query->paginate(10);

        return view('Owner.AuditAssets.photographer', compact('photographers'));
    }

    public function exportTransactions(Request $request)
    {
        $query = Transaction::with(['package', 'photographer', 'user']);

        // Re-apply filters for export
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'LIKE', "%{$search}%")
                  ->orWhere('customer_name', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $transactions = $query->get();

        $fileName = 'audit_transaksi_' . date('Ymd_His') . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Invoice', 'Customer', 'Paket', 'Photographer', 'Tanggal Transaksi', 'Tanggal Eksekusi', 'Total Amount', 'Status Pembayaran', 'Status Booking'];

        $callback = function() use($transactions, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->invoice_number,
                    $transaction->customer_name,
                    $transaction->package->name ?? '-',
                    $transaction->photographer->name ?? '-',
                    $transaction->created_at->format('Y-m-d H:i:s'),
                    $transaction->execution_date,
                    $transaction->total_amount,
                    $transaction->payment_status,
                    $transaction->booking_status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
