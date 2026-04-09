<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi Kelas</title>
    <style>
        /* CSS Langsung di dalam file PHP */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #1c1e21;
        }

        .container {
            max-width: 800px;
            width: 95%;
            padding: 20px;
            text-align: center;
        }

        header {
            margin-bottom: 40px;
        }

        header h1 {
            font-size: 2rem;
            color: #1877f2;
            margin-bottom: 8px;
        }

        header p {
            color: #606770;
        }

        .grid-menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .card {
            background: #ffffff;
            padding: 25px;
            border-radius: 15px;
            text-decoration: none;
            color: inherit;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #ddd;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
            border-color: #1877f2;
        }

        .card .emoji {
            font-size: 40px;
            margin-bottom: 15px;
            display: block;
        }

        .card h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #1c1e21;
        }

        .card p {
            font-size: 0.9rem;
            color: #65676b;
            line-height: 1.4;
        }

        footer {
            margin-top: 50px;
            font-size: 0.85rem;
            color: #8a8d91;
        }
    </style>
</head>

<body>

    <div class="container">
        <header>
            <h1>Sistem Absensi Kelas</h1>
            <p>Silakan pilih modul akses untuk melanjutkan</p>
        </header>

        <div class="grid-menu">
            <a href="admin_login.php" class="card">
                <span class="emoji">🛡️</span>
                <h3>Admin Area</h3>
                <p>Login sebagai administrator untuk kelola data.</p>
            </a>

            <a href="scan.php" class="card">
                <span class="emoji">📷</span>
                <h3>Scan Presensi</h3>
                <p>Gunakan QR Code untuk mencatat kehadiran.</p>
            </a>

            <a href="teacher_dashboard.php" class="card">
                <span class="emoji">👨‍🏫</span>
                <h3>Panel Guru</h3>
                <p>Dashboard khusus guru dan wali kelas.</p>
            </a>
        </div>

        <footer>
            &copy; <?php echo date("Y"); ?> Absensi Kelas App • Developed with PHP
        </footer>
    </div>

</body>

</html>