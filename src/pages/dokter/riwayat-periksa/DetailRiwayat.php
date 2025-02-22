<?php
include("../../../koneksi.php");

$id = $_GET['id'];

$obat = query("SELECT * FROM obat");

$query = "SELECT p.id, p.id_daftar_poli, p2.nama nama_pasien, p.tgl_periksa, p.catatan, p.biaya_periksa, dp.keluhan,
                  dp.no_antrian, jp.id_dokter, d.nama, p3.nama_poli, dp2.id as id_detail_periksa, dp2.id_obat,
                  o.nama_obat, o.kemasan, o.harga
           FROM periksa p
           JOIN daftar_poli dp on p.id_daftar_poli = dp.id
           JOIN pasien p2 on dp.id_pasien = p2.id
           JOIN jadwal_periksa jp on dp.id_jadwal = jp.id
           JOIN dokter d on jp.id_dokter = d.id
           JOIN poli p3 on d.id_poli = p3.id
           JOIN detail_periksa dp2 on dp2.id_periksa = p.id
           JOIN obat o on dp2.id_obat = o.id
           WHERE p.id = $id";
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Periksa Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="col-8 mt-5 mx-auto">
            <div class="card shadow bg-body-tertiary rounded">
                <div class="card-header mb-3" style="background-color: #48829E;">
                    <h5 class="card-title text-white my-auto">Detail Riwayat Pasien</h5>
                </div>
                <div class="card-body">
                    <form id="editForm" method="POST" action="./updateDetailPeriksa.php">
                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                        <input type="hidden" name="id_detail_periksa" value="<?= $row['id_detail_periksa']; ?>">


                        <div class="form-group mb-3">
                            <label for="nama_pasien">Nama Pasien</label>
                            <input type="text" class="form-control" id="nama_pasien" name="nama_pasien"
                                value="<?= $row['nama_pasien']; ?>" disabled>
                        </div>
                        <div class="form-group mb-3">
                            <label for="keluhan">Keluhan</label>
                            <input type="text" class="form-control" id="keluhan" name="keluhan"
                                value="<?= $row['keluhan']; ?>" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="catatan">Catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" style="height: 100px"
                                required><?= $row['catatan']; ?></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="obat">Obat</label>
                            <select class="form-control" id="obat" name="obat" onchange="updateTotal()">
                                <?php foreach ($obat as $obats): ?>
                                    <?php
                                    $selected = ($obats['id'] == $row['id_obat']) ? 'selected' : '';
                                    ?>
                                    <option value="<?= $obats['id']; ?>|<?= $obats['harga']; ?>" <?= $selected ?>>
                                        <?= $obats['nama_obat']; ?> - <?= $obats['kemasan']; ?> -
                                        Rp.<?= number_format($obats['harga'], 0, ',', '.'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="total_harga">Total Harga</label>
                            <input type="text" class="form-control" id="total_harga"
                                value="Rp. <?= number_format($row['biaya_periksa'], 0, ',', '.'); ?>" readonly>
                        </div>
                        <input type="submit" name="submit" value="Update" class="btn btn-info mt-3">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateTotal() {
            const select = document.getElementById('obat');
            const selectedOption = select.options[select.selectedIndex].value;
            const hargaObat = parseInt(selectedOption.split('|')[1]) || 0;
            const biayaTetap = 150000; // Biaya periksa tetap
            const total = biayaTetap + hargaObat;

            document.getElementById('total_harga').value = `Rp. ${total.toLocaleString('id-ID')}`;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>