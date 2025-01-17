<?php
include('../../../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama_dokter = $_POST['nama_dokter'];
    $alamat_dokter = $_POST['alamat_dokter'];
    $no_hp = $_POST['no_hp'];

    $query = "UPDATE dokter SET
              nama_dokter = ?,
              alamat_dokter = ?,
              no_hp = ?
              WHERE id = ?";

    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $nama_dokter, $alamat_dokter, $no_hp, $id);

    if (mysqli_stmt_execute($stmt)) {
        ?>
        <script>
            alert('Profil berhasil diperbarui!');
            window.location.href = "../index.php";
        </script>
        <?php
    } else {
        ?>
        <script>
            alert('Gagal memperbarui profil: <?php echo mysqli_error($mysqli); ?>');
            window.location.href = "../index.php";
        </script>
        <?php
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);
}
?>