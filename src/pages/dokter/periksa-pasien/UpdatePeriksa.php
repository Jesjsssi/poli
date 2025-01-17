<?php
include('../../../config/koneksi.php');

$hargaPeriksa = 150000;

if ($mysqli && $_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $tgl_periksa = $_POST["tgl_periksa"];
    $catatan = $_POST["catatan"];
    $obatArray = $_POST["obat"];

    // Calculate total medicine cost
    $totalBiayaObat = 0;
    $stmt = mysqli_prepare($mysqli, "SELECT harga FROM obat WHERE id = ?");

    foreach ($obatArray as $idObat) {
        if (!empty($idObat)) {
            mysqli_stmt_bind_param($stmt, "i", $idObat);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $totalBiayaObat += $row['harga'];
        }
    }

    mysqli_stmt_close($stmt);
    $biayaTotal = $hargaPeriksa + $totalBiayaObat;

    // Begin transaction
    mysqli_begin_transaction($mysqli);

    try {
        // Update periksa table
        $queryPeriksa = "UPDATE periksa SET tgl_periksa = ?, catatan = ?, biaya_periksa = ? WHERE id = ?";
        $stmtPeriksa = mysqli_prepare($mysqli, $queryPeriksa);
        mysqli_stmt_bind_param($stmtPeriksa, "ssii", $tgl_periksa, $catatan, $biayaTotal, $id);
        mysqli_stmt_execute($stmtPeriksa);
        mysqli_stmt_close($stmtPeriksa);

        // Delete old detail_periksa records
        $queryDelete = "DELETE FROM detail_periksa WHERE id_periksa = ?";
        $stmtDelete = mysqli_prepare($mysqli, $queryDelete);
        mysqli_stmt_bind_param($stmtDelete, "i", $id);
        mysqli_stmt_execute($stmtDelete);
        mysqli_stmt_close($stmtDelete);

        // Insert new detail_periksa records
        $queryDetail = "INSERT INTO detail_periksa (id_periksa, id_obat) VALUES (?, ?)";
        $stmtDetail = mysqli_prepare($mysqli, $queryDetail);

        foreach ($obatArray as $idObat) {
            if (!empty($idObat)) {
                mysqli_stmt_bind_param($stmtDetail, "ii", $id, $idObat);
                mysqli_stmt_execute($stmtDetail);
            }
        }

        mysqli_stmt_close($stmtDetail);
        mysqli_commit($mysqli);

        echo "<script>
                alert('Periksa berhasil diupdate!');
                window.location.href = '../index.php';
              </script>";
    } catch (Exception $e) {
        mysqli_rollback($mysqli);
        echo "Error: " . $e->getMessage();
    }

    mysqli_close($mysqli);
}
?>