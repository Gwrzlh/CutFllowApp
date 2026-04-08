@php
    $path = public_path('asset/Smartin-removebg-preview.png');
    if (file_exists($path)) {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    } else { $base64 = null; }
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk #{{ $transaction->invoice_number }}</title>
    <style>
        @page { margin: 0; }
        body { font-family: 'Courier', monospace; font-size: 10px; line-height: 1.2; color: #000; margin: 0; padding: 5mm; }
        .container { width: 100%; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .dashed-line { border-top: 1px dashed #000; margin: 5px 0; }
        .shop-name { font-size: 14px; font-weight: bold; }
        .address { font-size: 8px; margin-bottom: 5px; }
        .item-list { width: 100%; border-collapse: collapse; margin: 5px 0; }
        .footer { margin-top: 10px; font-size: 8px; }
        .logo-container { text-align: center; margin-bottom: 2px; height: 30px; }
        .styled-logo { height: 100%; filter: grayscale(100%); }
    </style>
</head>
<body>
    <div class="container">
        <div class="header text-center">
            @if($base64) <div class="logo-container"><img src="{{ $base64 }}" class="styled-logo"></div> @endif
            <div class="shop-name">CUTFLOW</div>
            <div class="address">Subang, Jawa Barat</div>
            <div>Inv: {{ $transaction->invoice_number }}</div>
        </div>

        <div class="dashed-line"></div>
        <table style="width: 100%">
            <tr>
                <td>Tgl: {{ $transaction->updated_at->format('d/m/y H:i') }}</td>
                <td class="text-right">Cust: {{ $transaction->customer_name }}</td>
            </tr>
        </table>
        <div class="dashed-line"></div>

        <table class="item-list">
            <tr>
                <td>{{ $transaction->package->name ?? 'Paket Foto' }}</td>
                <td class="text-right">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
            </tr>
            @if($transaction->booking_status == 'cancelled')
            <tr>
                <td style="color: red;">(CANCELLED - FEE 25%)</td>
                <td class="text-right">- Rp {{ number_format($transaction->total_amount * 0.75, 0, ',', '.') }}</td>
            </tr>
            @endif
        </table>

        <div class="dashed-line"></div>
        <table style="width: 100%">
            <tr>
                <td>TOTAL</td>
                <td class="text-right font-bold">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>TELAH DIBAYAR</td>
                <td class="text-right">Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>KEMBALI</td>
                <td class="text-right">Rp {{ number_format($transaction->cash_change ?? 0, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="dashed-line"></div>
        <div class="footer text-center">
            <p>Status: {{ strtoupper($transaction->payment_status) }}<br>
            Booking: {{ strtoupper($transaction->booking_status) }}</p>
            <div style="font-size: 7px;">Terima kasih atas kunjungan Anda</div>
        </div>
    </div>
</body>
</html>