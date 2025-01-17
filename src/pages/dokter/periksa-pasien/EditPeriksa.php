<?php
session_start();
include('../../../config/koneksi.php');

if ($mysqli && $_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $tgl_periksa = $_POST['tgl_periksa'];
    $catatan = $_POST['catatan'];
    $obatArray = $_POST['obat'];
    $total_biaya = str_replace(['Rp. ', '.'], '', $_POST['total_biaya']);

    mysqli_begin_transaction($mysqli);

    try {
        // Update periksa table
        $query = "UPDATE periksa SET tgl_periksa = ?, catatan = ?, biaya_periksa = ? WHERE id = ?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "ssii", $tgl_periksa, $catatan, $total_biaya, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Delete existing detail_periksa
        $delete_detail = "DELETE FROM detail_periksa WHERE id_periksa = ?";
        $stmt_delete = mysqli_prepare($mysqli, $delete_detail);
        mysqli_stmt_bind_param($stmt_delete, "i", $id);
        mysqli_stmt_execute($stmt_delete);
        mysqli_stmt_close($stmt_delete);

        // Insert new detail_periksa for each medicine
        if (!empty($obatArray)) {
            $insert_detail = "INSERT INTO detail_periksa (id_periksa, id_obat) VALUES (?, ?)";
            $stmt_detail = mysqli_prepare($mysqli, $insert_detail);

            foreach ($obatArray as $obat_id) {
                if (!empty($obat_id)) {
                    mysqli_stmt_bind_param($stmt_detail, "ii", $id, $obat_id);
                    mysqli_stmt_execute($stmt_detail);
                }
            }
            mysqli_stmt_close($stmt_detail);
        }

        mysqli_commit($mysqli);
        ?>
        <script>
            alert("Data periksa berhasil diupdate!");
            window.location.href = "../index.php";
        </script>
        <?php
        exit();

    } catch (Exception $e) {
        mysqli_rollback($mysqli);
        echo "Error: " . $e->getMessage();
    }

    mysqli_close($mysqli);
}
?>