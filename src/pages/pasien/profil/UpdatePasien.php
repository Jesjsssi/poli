<?php
include('../../../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama_pasien = $_POST['nama_pasien'];
    $alamat_pasien = $_POST['alamat_pasien'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];

    $query = "UPDATE pasien SET
              nama_pasien = ?,
              alamat_pasien = ?,
              no_ktp = ?,
              no_hp = ?
              WHERE id = ?";

    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "ssssi", $nama_pasien, $alamat_pasien, $no_ktp, $no_hp, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success', 'message' => 'Profil berhasil diperbarui!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui profil: ' . mysqli_error($mysqli)]);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);
}
?>