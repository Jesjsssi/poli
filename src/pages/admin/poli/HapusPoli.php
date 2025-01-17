<?php
include '../../../config/koneksi.php';
$id = $_GET['id'];

// Check if poli is referenced by any dokter
$check_query = "SELECT * FROM dokter WHERE id_poli = '$id'";
$check_result = mysqli_query($mysqli, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    // Poli is being used by dokter, show error
    echo "<script>
        alert('Poli tidak dapat dihapus karena masih digunakan oleh dokter.');
        window.location.href = '../index.php';
    </script>";
} else {
    // Safe to delete poli
    $delete_query = "DELETE FROM poli WHERE id = '$id'";
    $result = mysqli_query($mysqli, $delete_query);

    if ($result) {
        echo "<script>
            alert('Data poli berhasil dihapus.');
            window.location.href = '../index.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus data poli.');
            window.location.href = '../index.php';
        </script>";
    }
}

mysqli_close($mysqli);
?>