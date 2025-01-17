<?php
// File: pages/riwayat/get_riwayat.php
include_once("../../../config/koneksi.php");
session_start();

header('Content-Type: text/html; charset=utf-8');

if (!isset($_POST['id_pasien']) || !isset($_POST['id_dokter'])) {
    echo "<tr><td colspan='5' class='text-center'>Error: Invalid request</td></tr>";
    exit;
}

try {
    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];

    $sql = "SELECT PERIKSA.tgl_periksa,
        DAFTAR_POLI.keluhan,
        PERIKSA.catatan,
        GROUP_CONCAT(OBAT.nama_obat SEPARATOR ', ') as nama_obat,
        PERIKSA.biaya_periksa
    FROM periksa AS PERIKSA
    JOIN daftar_poli AS DAFTAR_POLI ON PERIKSA.id_daftar_poli = DAFTAR_POLI.id
    JOIN jadwal_periksa AS JADWAL ON DAFTAR_POLI.id_jadwal = JADWAL.id
    LEFT JOIN detail_periksa AS DETAIL ON PERIKSA.id = DETAIL.id_periksa
    LEFT JOIN obat AS OBAT ON DETAIL.id_obat = OBAT.id
    WHERE DAFTAR_POLI.id_pasien = ? AND JADWAL.id_dokter = ?
    GROUP BY PERIKSA.id
    ORDER BY PERIKSA.tgl_periksa DESC";

    $stmt = mysqli_prepare($mysqli, $sql);
    if ($stmt === false) {
        throw new Exception('Error preparing statement: ' . mysqli_error($mysqli));
    }

    mysqli_stmt_bind_param($stmt, "ii", $id_pasien, $id_dokter);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Error executing statement: ' . mysqli_stmt_error($stmt));
    }

    $result = mysqli_stmt_get_result($stmt);

    if ($result === false) {
        throw new Exception('Error getting result: ' . mysqli_error($mysqli));
    }

    $hasData = false;

    while ($row = mysqli_fetch_assoc($result)) {
        $hasData = true;
        echo "<tr>";
        echo "<td>" . date('d/m/Y H:i', strtotime($row['tgl_periksa'])) . "</td>";
        echo "<td>" . htmlspecialchars($row['keluhan']) . "</td>";
        echo "<td>" . htmlspecialchars($row['catatan']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nama_obat'] ?? '-') . "</td>";
        echo "<td>Rp. " . number_format($row['biaya_periksa'], 0, ',', '.') . "</td>";
        echo "</tr>";
    }

    if (!$hasData) {
        echo "<tr><td colspan='5' class='text-center'>Tidak ada riwayat pemeriksaan</td></tr>";
    }

} catch (Exception $e) {
    echo "<tr><td colspan='5' class='text-center'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
}
?>