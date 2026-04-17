<?php
session_start();

// Redirect jika sudah login
if (isset($_SESSION['student_id'])) {
    header('Location: pages/dashboard.php');
    exit;
}
if (isset($_SESSION['admin_id'])) {
    header('Location: pages/admin_dashboard.php');
    exit;
}

// Dummy login handler (replace dengan database nanti)
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = $_POST['identifier'] ?? '';
    $password = $_POST['password'] ?? '';

    // Dummy validation untuk admin
    if ($identifier === 'admin' && $password === 'admin123') {
        $_SESSION['admin_id'] = 1;
        $_SESSION['admin_name'] = 'Administrator';
        header('Location: pages/admin_dashboard.php');
        exit;
    }
    // Dummy validation untuk siswa - ganti dengan query database
    elseif ($identifier === '12345' && $password === 'siswa123') {
        $_SESSION['student_id'] = $identifier;
        $_SESSION['student_name'] = 'Ahmad Fauzi';
        $_SESSION['student_class'] = 'XII IPA 1';
        header('Location: pages/dashboard.php');
        exit;
    } else {
        $error = 'NIS/Username atau password salah';
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi Siswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --background: #fafafa;
            --foreground: #0a0a0a;
            --card: #ffffff;
            --card-foreground: #0a0a0a;
            --primary: #0a0a0a;
            --primary-foreground: #fafafa;
            --muted: #f5f5f5;
            --muted-foreground: #737373;
            --border: #e5e5e5;
            --input: #e5e5e5;
            --ring: #0a0a0a;
            --radius: 0.75rem;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--foreground);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo {
            width: 48px;
            height: 48px;
            background-color: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .logo svg {
            width: 24px;
            height: 24px;
            color: var(--primary-foreground);
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        .login-header p {
            color: var(--muted-foreground);
            font-size: 0.875rem;
        }

        .login-card {
            background-color: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--foreground);
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            border: 1px solid var(--input);
            border-radius: calc(var(--radius) - 4px);
            background-color: var(--background);
            color: var(--foreground);
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: inherit;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--ring);
            box-shadow: 0 0 0 3px rgba(10, 10, 10, 0.1);
        }

        .form-input::placeholder {
            color: var(--muted-foreground);
        }

        .error-message {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 0.75rem 1rem;
            border-radius: calc(var(--radius) - 4px);
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
        }

        .btn-primary {
            width: 100%;
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--primary-foreground);
            background-color: var(--primary);
            border: none;
            border-radius: calc(var(--radius) - 4px);
            cursor: pointer;
            transition: opacity 0.2s;
            font-family: inherit;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        .btn-primary:active {
            transform: scale(0.98);
        }

        .demo-info {
            margin-top: 1.5rem;
            padding: 1rem;
            background-color: var(--muted);
            border-radius: calc(var(--radius) - 4px);
            font-size: 0.75rem;
            color: var(--muted-foreground);
        }

        .demo-info strong {
            color: var(--foreground);
            font-weight: 500;
        }

        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.75rem;
            color: var(--muted-foreground);
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
            </div>
            <h1>Sistem Absensi Sekolah</h1>
            <p>Masuk dengan akun siswa atau administrator</p>
        </div>

        <div class="login-card">
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label" for="identifier">NIS / Username</label>
                    <input
                        type="text"
                        id="identifier"
                        name="identifier"
                        class="form-input"
                        placeholder="Masukkan NIS atau Username"
                        required
                        autocomplete="username">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input"
                        placeholder="Masukkan password"
                        required
                        autocomplete="current-password">
                </div>

                <button type="submit" class="btn-primary">Masuk</button>
            </form>

            <div class="demo-info">
                <strong>Demo Akun Siswa:</strong><br>
                NIS: 12345<br>
                Password: siswa123<br><br>
                <strong>Demo Akun Admin:</strong><br>
                Username: admin<br>
                Password: admin123
            </div>
        </div>

        <p class="footer-text">© 2026 Sistem Absensi Sekolah</p>
    </div>
</body>

</html>