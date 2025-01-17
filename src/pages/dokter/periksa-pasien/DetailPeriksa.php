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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Periksa Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: #48829E;
            padding: 1rem 1.5rem;
            border-bottom: none;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-control:disabled {
            background-color: #f8f9fa;
        }

        .price-display {
            font-size: 1.1rem;
            font-weight: 500;
            color: #48829E;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-white mb-0">Detail Periksa Pasien</h5>
                    </div>
                    <div class="card-body p-4">
                        <form id="editForm" method="POST" action="./updateDetailPeriksa.php">
                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                            <input type="hidden" name="id_detail_periksa" value="<?= $row['id_detail_periksa']; ?>">

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="nama_pasien">Nama Pasien</label>
                                        <input type="text" class="form-control" id="nama_pasien"
                                            value="<?= htmlspecialchars($row['nama_pasien']); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="keluhan">Keluhan</label>
                                        <input type="text" class="form-control" id="keluhan"
                                            value="<?= htmlspecialchars($row['keluhan']); ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="tgl_periksa">Tanggal Periksa</label>
                                        <input type="datetime-local" class="form-control" id="tgl_periksa"
                                            name="tgl_periksa" value="<?= $row['tgl_periksa']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="obat">Obat</label>
                                        <select class="form-select" id="obat" name="obat" onchange="updateTotal()">
                                            <?php foreach ($obat as $obats): ?>
                                                <?php $selected = ($obats['id'] == $row['id_obat']) ? 'selected' : ''; ?>
                                                <option value="<?= $obats['id']; ?>|<?= $obats['harga']; ?>" <?= $selected ?>>
                                                    <?= htmlspecialchars($obats['nama_obat']); ?> -
                                                    <?= htmlspecialchars($obats['kemasan']); ?> -
                                                    Rp. <?= number_format($obats['harga'], 0, ',', '.'); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" for="catatan">Catatan</label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="4"
                                    required><?= htmlspecialchars($row['catatan']); ?></textarea>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" for="total_harga">Total Biaya</label>
                                <div class="price-display p-2 bg-light rounded">
                                    <span id="total_harga">Rp.
                                        <?= number_format($row['biaya_periksa'], 0, ',', '.'); ?></span>
                                </div>
                                <small class="text-muted">*Biaya sudah termasuk biaya pemeriksaan (Rp. 150.000)</small>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Update Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize total on page load
            updateTotal();
        });

        function updateTotal() {
            const select = document.getElementById('obat');
            const selectedOption = select.options[select.selectedIndex].value;
            const [_, hargaStr] = selectedOption.split('|');
            const hargaObat = parseInt(hargaStr) || 0;
            const biayaPemeriksaan = 150000;
            const total = biayaPemeriksaan + hargaObat;

            // Format currency
            const formattedTotal = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(total);

            // Update display (remove 'IDR' prefix and replace with 'Rp. ')
            document.getElementById('total_harga').textContent = formattedTotal.replace('IDR', 'Rp.');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>