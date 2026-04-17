<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Kreait\Firebase\Factory;

// Pastikan file service-account.json ada di folder absensi_kelas (folder utama)
$serviceAccount = __DIR__ . '/../service-account.json';

// Cek apakah file credentials Firebase ada
if (!file_exists($serviceAccount)) {
    die("Error: File service-account.json tidak ditemukan. Silakan unduh dari Firebase Console -> Project Settings -> Service Accounts, lalu letakkan di: " . realpath(__DIR__ . '/..') . "/");
}

try {
    // Inisialisasi Factory dengan credential (menggunakan syntax v5+)
    $factory = (new Factory)->withServiceAccount($serviceAccount);

    // Inisialisasi Firestore
    $firestore = $factory->createFirestore();

    // Ini adalah objek database yang akan dipakai untuk query Firestore (CRUD)
    $database = $firestore->database();

    // Hapus atau comment baris ini jika project sudah live agar tidak mengganggu output
    // echo "Koneksi Firestore Berhasil!"; 
} catch (\Exception $e) {
    die("Koneksi Firebase/Firestore Gagal: " . $e->getMessage());
}
