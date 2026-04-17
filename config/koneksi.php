<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Kreait\Firebase\Factory;

// Pastikan file service-account.json ada di folder absensi_kelas (folder utama)
$serviceAccount = __DIR__ . '/../service-account.json';

try {
    $factory = (Factory::create())
        ->withServiceAccount($serviceAccount);

    // Inisialisasi Firestore
    $firestore = $factory->createFirestore();

    // Ini adalah objek database yang akan kamu pakai di file lain
    $database = $firestore->database();

    // echo "Koneksi Firestore Berhasil!"; 
} catch (\Exception $e) {
    echo "Gagal koneksi: " . $e->getMessage();
}
