<?php
include '../../../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nama_pasien = $_POST["nama_pasien"];
    $alamat_pasien = $_POST["alamat_pasien"];
    $no_ktp = $_POST["no_ktp"];
    $no_hp = $_POST["no_hp"];

    $query = "UPDATE pasien SET
        nama_pasien = ?,
        alamat_pasien = ?,
        no_ktp = ?,
        no_hp = ?
        WHERE id = ?";

    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, 'ssssi', $nama_pasien, $alamat_pasien, $no_ktp, $no_hp, $id);

    if (mysqli_stmt_execute($stmt)) {
        ?>
        <script>
            alert("Data pasien berhasil diubah!");
            window.location.href = "../index.php";
        </script>
        <?php
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($mysqli);
?>