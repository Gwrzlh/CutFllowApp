<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - Cutflow</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0A3D91;
            --secondary: #D4AF37;
            --bg: #F5F6FA;
            --text: #2D3436;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); margin: 0; padding: 20px; color: var(--text); }
        .header { display: flex; justify-content: space-between; align-items: center; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .logout-btn { background: #FF4757; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; text-decoration: none; }
        .content { margin-top: 20px; background: white; padding: 40px; border-radius: 12px; min-height: 400px; text-align: center; }
        .badge { background: #EE5253; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h2 style="margin:0">Owner Dashboard</h2>
            <p style="margin:5px 0 0; color:#636E72">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong> <span class="badge">OWNER</span></p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="content">
        <h1>Reports & Analytics</h1>
        <p>Silakan gunakan menu navigasi untuk melihat laporan bisnis.</p>
    </div>
</body>
</html>
