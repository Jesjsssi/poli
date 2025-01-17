<?php
include '../../../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nama_poli = $_POST["nama_poli"];
    $keterangan = $_POST["keterangan"];

    $query = "UPDATE poli SET
        nama_poli = '$nama_poli',
        keterangan = '$keterangan'
        WHERE id = '$id'";

    if (mysqli_query($mysqli, $query)) {
        ?>
        <script>
            alert("Data poli berhasil diubah!")
            window.location.href = "../index.php"
        </script>
        <?php
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
    }
}
mysqli_close($mysqli);
?>