<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\LogActivity;
use App\Models\packages;
use App\Models\photographer;
use App\Models\lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class transaksiController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['package', 'photographer', 'lokasi', 'user'])
            ->orderBy('created_at', 'desc')->get();
        $packages = packages::where('is_active', true)->get();
        $photographers = photographer::all();
        $locations = lokasi::all();

        return view('Kasir.transaksi.index', compact('transactions', 'packages', 'photographers', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'package_id' => 'required|exists:packages,id',
            'photographer_id' => 'required|exists:photographers,id',
            'location_id' => 'required|exists:locations,id',
            'execution_date' => 'required|date|after_or_equal:today',
            'amount_paid' => 'required|integer|min:0',
        ]);

        // Cek Bentrok Jadwal
        $exists = Transaction::where('photographer_id', $request->photographer_id)
            ->where('execution_date', $request->execution_date)
            ->where('booking_status', '!=', 'cancelled')
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Photographer sudah di-booking pada tanggal tersebut')->withInput();
        }

        DB::beginTransaction();
        try {
            $package = packages::findOrFail($request->package_id);
            $total_price = $package->price;
            
            // Hitung Kembalian (Opsional disimpan)
            $cash_received = $request->cash_received ?? $request->amount_paid;
            $cash_change = $cash_received - $request->amount_paid;

            // Logika Status
            $payment_status = 'unpaid';
            $booking_status = 'scheduled';

            if ($request->amount_paid >= $total_price) {
                $payment_status = 'paid_off';
                $booking_status = 'completed';
            } elseif ($request->amount_paid > 0) {
                $payment_status = 'down_payment';
            }

            $transaction = Transaction::create([
                'invoice_number' => 'TEMP-' . time(),
                'customer_name' => $request->customer_name,
                'package_id' => $request->package_id,
                'photographer_id' => $request->photographer_id,
                'user_id' => Auth::id(),
                'total_amount' => $total_price,
                'amount_paid' => $request->amount_paid,
                'cash_change' => $cash_change,
                'payment_status' => $payment_status,
                'booking_status' => $booking_status,
                'execution_date' => $request->execution_date,
                'location_id' => $request->location_id,
            ]);

            $transaction->update(['invoice_number' => 'INV-' . str_pad($transaction->id, 5, '0', STR_PAD_LEFT)]);

            DB::commit();

            LogActivity::create([
                'user_id' => Auth::id(),
                'action' => 'Melakukan transaksi baru: ' . $transaction->invoice_number,
                'module' => 'Transactions'
            ]);

            return redirect()->back()->with('success', 'Booking #' . $transaction->invoice_number . ' Berhasil!')->with('print_id', $transaction->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function cancel($id)
    {
        DB::beginTransaction();
        try {
            $transaction = Transaction::findOrFail($id);

            if ($transaction->booking_status === 'cancelled') {
                return redirect()->back()->with('error', 'Transaksi sudah dibatalkan.');
            }

            // Hitung pengembalian (Misal DP 50.000, potong 25% = 12.500, dikembalikan 37.500)
            $refundAmount = $transaction->amount_paid * 0.75;
            $adminFee = $transaction->amount_paid * 0.25;

            $transaction->update([
                'booking_status' => 'cancelled',
                'payment_status' => 'unpaid',
                'notes' => "Dibatalkan. Total DP: {$transaction->amount_paid}. Biaya Admin (25%): {$adminFee}. Dikembalikan: {$refundAmount}"
            ]);

            DB::commit();

            LogActivity::create([
                'user_id' => Auth::id(),
                'action' => 'Membatalkan transaksi: ' . $transaction->invoice_number,
                'module' => 'Transactions'
            ]);

            return redirect()->back()->with('success', "Booking dibatalkan. Dana yang dikembalikan ke customer: Rp " . number_format($refundAmount))->with('print_id', $transaction->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membatalkan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount_paid' => 'required|numeric', // Ini adalah sisa pelunasan
        ]);

        try {
            $transaction = Transaction::findOrFail($id);
            
            // Update data yang sudah ada
            $transaction->update([
                'amount_paid' => $transaction->total_amount, // Set ke total harga karena sudah lunas
                'payment_status' => 'paid_off',
                'booking_status' => 'completed',
                'cash_change' => ($request->cash_received ?? $request->amount_paid) - $request->amount_paid,
            ]);

            LogActivity::create([
                'user_id' => Auth::id(),
                'action' => 'Melunasi transaksi: ' . $transaction->invoice_number,
                'module' => 'Transactions'
            ]);

            return redirect()->back()->with('success', 'Pelunasan berhasil!')->with('print_id', $transaction->id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal melunasi.');
        }
    }
    public function printInvoice($id) {
        $transaction = Transaction::with(['package', 'photographer'])->findOrFail($id);
        $pdf = Pdf::loadView('Kasir.modal.struk', compact('transaction'))
                ->setPaper([0, 0, 204, 500]); // Ukuran struk thermal 72mm
        return $pdf->stream('invoice-'.$transaction->invoice_number.'.pdf');
    }
public function riwayat()
{
    $transactions = Transaction::with(['package', 'photographer'])->orderBy('created_at', 'desc')->get();
    return view('Kasir.riwayat.index', compact('transactions'));
}
}
