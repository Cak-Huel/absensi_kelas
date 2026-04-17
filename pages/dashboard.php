<?php
session_start();

// Redirect ke login jika belum login
if (!isset($_SESSION['student_id'])) {
    header('Location: index.php');
    exit;
}

$studentName = $_SESSION['student_name'] ?? 'Siswa';
$studentClass = $_SESSION['student_class'] ?? '-';
$studentId = $_SESSION['student_id'] ?? '-';

// Dummy attendance data
$todayDate = date('d F Y');
$currentTime = date('H:i');

// Dummy attendance status
$attendanceToday = null; // null = belum absen, 'hadir' = sudah absen
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Absensi Siswa</title>
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
            --success: #22c55e;
            --success-light: #dcfce7;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--foreground);
            min-height: 100vh;
        }

        /* Header */
        .header {
            background-color: var(--card);
            border-bottom: 1px solid var(--border);
            padding: 1rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            max-width: 600px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-logo-icon {
            width: 36px;
            height: 36px;
            background-color: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-logo-icon svg {
            width: 18px;
            height: 18px;
            color: var(--primary-foreground);
        }

        .header-logo span {
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: -0.025em;
        }

        .btn-logout {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--muted-foreground);
            background-color: transparent;
            border: 1px solid var(--border);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
            text-decoration: none;
        }

        .btn-logout:hover {
            background-color: var(--muted);
            color: var(--foreground);
        }

        /* Main Content */
        .main-content {
            max-width: 600px;
            margin: 0 auto;
            padding: 1.5rem;
        }

        /* Greeting Section */
        .greeting {
            margin-bottom: 1.5rem;
        }

        .greeting-time {
            font-size: 0.75rem;
            color: var(--muted-foreground);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }

        .greeting h1 {
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: -0.025em;
        }

        .greeting h1 span {
            color: var(--muted-foreground);
            font-weight: 400;
        }

        /* Student Info Card */
        .student-card {
            background-color: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .student-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .student-avatar {
            width: 48px;
            height: 48px;
            background-color: var(--muted);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
            color: var(--muted-foreground);
        }

        .student-details h3 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .student-details p {
            font-size: 0.875rem;
            color: var(--muted-foreground);
        }

        /* Scan QR Button */
        .scan-section {
            margin-bottom: 1.5rem;
        }

        .btn-scan {
            width: 100%;
            padding: 1.25rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary-foreground);
            background-color: var(--primary);
            border: none;
            border-radius: var(--radius);
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .btn-scan:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-scan:active {
            transform: translateY(0);
        }

        .btn-scan svg {
            width: 24px;
            height: 24px;
        }

        /* Status Card */
        .status-card {
            background-color: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .status-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .status-header h3 {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--muted-foreground);
        }

        .status-date {
            font-size: 0.75rem;
            color: var(--muted-foreground);
        }

        .status-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-badge.pending {
            background-color: var(--muted);
            color: var(--muted-foreground);
        }

        .status-badge.success {
            background-color: var(--success-light);
            color: #166534;
        }

        .status-time {
            font-size: 0.875rem;
            color: var(--muted-foreground);
        }

        /* Quick Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
        }

        .stat-card {
            background-color: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1rem;
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.625rem;
            color: var(--muted-foreground);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* QR Scanner Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 1rem;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            background-color: var(--card);
            border-radius: var(--radius);
            width: 100%;
            max-width: 400px;
            overflow: hidden;
        }

        .modal-header {
            padding: 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h2 {
            font-size: 1rem;
            font-weight: 600;
        }

        .btn-close {
            width: 32px;
            height: 32px;
            border: none;
            background-color: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            color: var(--muted-foreground);
            transition: all 0.2s;
        }

        .btn-close:hover {
            background-color: var(--muted);
            color: var(--foreground);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .scanner-area {
            aspect-ratio: 1;
            background-color: var(--muted);
            border-radius: calc(var(--radius) - 4px);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .scanner-area video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .scanner-frame {
            position: absolute;
            inset: 20%;
            border: 2px solid var(--primary);
            border-radius: 12px;
        }

        .scanner-placeholder {
            text-align: center;
            color: var(--muted-foreground);
        }

        .scanner-placeholder svg {
            width: 48px;
            height: 48px;
            margin-bottom: 0.75rem;
            opacity: 0.5;
        }

        .scanner-placeholder p {
            font-size: 0.875rem;
        }

        .modal-footer {
            padding: 1.25rem;
            border-top: 1px solid var(--border);
        }

        .scanner-hint {
            font-size: 0.75rem;
            color: var(--muted-foreground);
            text-align: center;
        }

        /* Success Message */
        .success-message {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .success-message.active {
            display: block;
        }

        .success-icon {
            width: 64px;
            height: 64px;
            background-color: var(--success-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .success-icon svg {
            width: 32px;
            height: 32px;
            color: var(--success);
        }

        .success-message h3 {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .success-message p {
            font-size: 0.875rem;
            color: var(--muted-foreground);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .header {
                padding: 0.75rem 1rem;
            }

            .main-content {
                padding: 1rem;
            }

            .greeting h1 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="header-logo">
                <div class="header-logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                </div>
                <span>Absensi</span>
            </div>
            <a href="logout.php" class="btn-logout">Keluar</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Greeting -->
        <div class="greeting">
            <p class="greeting-time"><?php echo $todayDate; ?></p>
            <h1>Halo, <span><?php echo htmlspecialchars($studentName); ?></span></h1>
        </div>

        <!-- Student Info -->
        <div class="student-card">
            <div class="student-info">
                <div class="student-avatar">
                    <?php echo strtoupper(substr($studentName, 0, 2)); ?>
                </div>
                <div class="student-details">
                    <h3><?php echo htmlspecialchars($studentName); ?></h3>
                    <p>NIS: <?php echo htmlspecialchars($studentId); ?> • <?php echo htmlspecialchars($studentClass); ?></p>
                </div>
            </div>
        </div>

        <!-- Scan QR Button -->
        <div class="scan-section">
            <button class="btn-scan" id="openScanner">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h2M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                Scan QR untuk Absen
            </button>
        </div>

        <!-- Status Today -->
        <div class="status-card">
            <div class="status-header">
                <h3>Status Hari Ini</h3>
                <span class="status-date"><?php echo $currentTime; ?> WIB</span>
            </div>
            <div class="status-content">
                <span class="status-badge pending" id="statusBadge">Belum Absen</span>
                <span class="status-time" id="statusTime">-</span>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">24</div>
                <div class="stat-label">Hadir</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">2</div>
                <div class="stat-label">Izin</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">1</div>
                <div class="stat-label">Sakit</div>
            </div>
        </div>
    </main>

    <!-- QR Scanner Modal -->
    <div class="modal-overlay" id="scannerModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Scan QR Code</h2>
                <button class="btn-close" id="closeScanner">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="scanner-area" id="scannerArea">
                    <video id="scannerVideo" autoplay playsinline></video>
                    <div class="scanner-frame"></div>
                    <div class="scanner-placeholder" id="scannerPlaceholder">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                        </svg>
                        <p>Klik untuk mengaktifkan kamera</p>
                    </div>
                </div>

                <!-- Success Message (hidden by default) -->
                <div class="success-message" id="successMessage">
                    <div class="success-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3>Absensi Berhasil!</h3>
                    <p id="successTime">Tercatat pada pukul 07:30 WIB</p>
                </div>
            </div>
            <div class="modal-footer" id="scannerFooter">
                <p class="scanner-hint">Arahkan kamera ke QR Code yang tersedia di kelas</p>
            </div>
        </div>
    </div>

    <script>
        // Elements
        const openScannerBtn = document.getElementById('openScanner');
        const closeScannerBtn = document.getElementById('closeScanner');
        const scannerModal = document.getElementById('scannerModal');
        const scannerVideo = document.getElementById('scannerVideo');
        const scannerPlaceholder = document.getElementById('scannerPlaceholder');
        const scannerArea = document.getElementById('scannerArea');
        const successMessage = document.getElementById('successMessage');
        const scannerFooter = document.getElementById('scannerFooter');
        const statusBadge = document.getElementById('statusBadge');
        const statusTime = document.getElementById('statusTime');
        const successTime = document.getElementById('successTime');

        let stream = null;

        // Open scanner modal
        openScannerBtn.addEventListener('click', () => {
            scannerModal.classList.add('active');
            startCamera();
        });

        // Close scanner modal
        closeScannerBtn.addEventListener('click', closeScanner);

        // Close when clicking overlay
        scannerModal.addEventListener('click', (e) => {
            if (e.target === scannerModal) {
                closeScanner();
            }
        });

        // Start camera
        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment'
                    }
                });
                scannerVideo.srcObject = stream;
                scannerPlaceholder.style.display = 'none';
                scannerVideo.style.display = 'block';

                // Simulate QR detection after 3 seconds (demo purpose)
                setTimeout(() => {
                    if (scannerModal.classList.contains('active')) {
                        onQRDetected();
                    }
                }, 3000);
            } catch (err) {
                console.error('Camera error:', err);
                scannerPlaceholder.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <p>Tidak dapat mengakses kamera</p>
                `;
            }
        }

        // On QR detected
        function onQRDetected() {
            // Stop camera
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }

            // Hide scanner, show success
            scannerArea.style.display = 'none';
            successMessage.classList.add('active');
            scannerFooter.style.display = 'none';

            // Update time
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
            successTime.textContent = `Tercatat pada pukul ${timeStr} WIB`;

            // Update status on dashboard
            statusBadge.textContent = 'Hadir';
            statusBadge.classList.remove('pending');
            statusBadge.classList.add('success');
            statusTime.textContent = timeStr + ' WIB';

            // Close modal after 2 seconds
            setTimeout(() => {
                closeScanner();
            }, 2000);
        }

        // Close scanner
        function closeScanner() {
            scannerModal.classList.remove('active');

            // Stop camera
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }

            // Reset modal state
            setTimeout(() => {
                scannerArea.style.display = 'flex';
                scannerVideo.style.display = 'none';
                scannerPlaceholder.style.display = 'flex';
                scannerPlaceholder.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                    </svg>
                    <p>Klik untuk mengaktifkan kamera</p>
                `;
                successMessage.classList.remove('active');
                scannerFooter.style.display = 'block';
            }, 300);
        }
    </script>
</body>

</html>