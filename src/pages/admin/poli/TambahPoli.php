<?php
include '../../../config/koneksi.php';

if ($mysqli) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama_poli = $_POST["nama_poli"];
        $keterangan = $_POST["keterangan"];

        $query = "INSERT INTO poli (nama_poli, keterangan) VALUES ('$nama_poli', '$keterangan')";

        if (mysqli_query($mysqli, $query)) {
            ?>
            <script>
                alert("Data poli berhasil ditambahkan!")
                window.location.href = "../index.php"
            </script>
            <?php
            exit();
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
        }
    }

    mysqli_close($mysqli);
} else {
    echo "Failed to include koneksi.php";
}
?>