<?php
session_start();

$pasien_id = $_SESSION['id'];
$no_rm = $_SESSION['no_rm'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Poli</title>
    <style>
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .rating input {
            display: none;
        }

        .rating label {
            cursor: pointer;
            font-size: 30px;
            color: #ddd;
            padding: 5px;
        }

        .rating input:checked~label {
            color: #ffd700;
        }

        .rating label:hover,
        .rating label:hover~label {
            color: #ffd700;
        }
    </style>
</head>

<body>

    <!-- Registration Form Section Second -->
    <div class="form-daftar w-100">
        <div class="card border rounded-lg w-100" style="background-color: white; overflow: hidden;">
            <div class="card-header bg-primary">
                <h3 class="card-title text-white">Daftar Poliklinik</h3>
            </div>
            <form action="../pasien/dashboard/TambahPeriksa.php" method="POST" class="py-2 px-3">
                <input type="hidden" value="<?php echo $pasien_id; ?>" name="id_pasien">
                <div class="form-group my-2">
                    <label for="no_rm">Nomor Rekam Medis</label>
                    <input class="w-100 px-4 rounded-lg border form-control" type="text" name="no_rm" id="no_rm"
                        value="<?php echo $no_rm ?>" disabled required>
                </div>
                <div class="form-group my-2">
                    <label for="poliklinik">Pilih Poliklinik</label>
                    <select class="form-control" id="poliklinik" name="poliklinik" required>
                        <?php
                        $queryPoli = "SELECT * FROM poli";
                        $resultPoli = mysqli_query($mysqli, $queryPoli);
                        while ($rowPoli = mysqli_fetch_assoc($resultPoli)) {
                            echo "<option value='{$rowPoli['id']}'>{$rowPoli['nama_poli']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group my-2">
                    <label for="jadwal">Pilih Jadwal</label>
                    <select class="form-control" id="jadwal" name="jadwal" required>
                        <?php
                        $queryJadwal = "SELECT jadwal_periksa.id, dokter.nama_dokter AS nama_dokter, jadwal_periksa.hari, jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai
                        FROM jadwal_periksa
                        JOIN dokter ON jadwal_periksa.id_dokter = dokter.id";
                        $resultJadwal = mysqli_query($mysqli, $queryJadwal);

                        while ($rowJadwal = mysqli_fetch_assoc($resultJadwal)) {
                            $namaDokter = $rowJadwal['nama_dokter'];
                            $hari = $rowJadwal['hari'];
                            $jamMulai = $rowJadwal['jam_mulai'];
                            $jamSelesai = $rowJadwal['jam_selesai'];
                            echo "<option value='{$rowJadwal['id']}'>{$namaDokter} | {$hari} | {$jamMulai} - {$jamSelesai}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-floating">
                    <label for="keluhan">Keluhan</label>
                    <textarea class="form-control" placeholder="Tuliskan keluhan anda" id="keluhan" name="keluhan"
                        style="height: 100px" required></textarea>
                </div>
                <div class="mt-3 form-group d-flex justify-content-end align-items-center">
                    <button type="submit"
                        class="w-auto px-4 btn btn-block rounded-2 text-white bg-primary">Daftar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex flex-column align-items-center">
        <!-- Registration History Section First -->
        <div class="riwayat-daftar w-100 mb-4">
            <div class="card w-100">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">Riwayat Pendaftaran</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Poliklinik</th>
                                <th>Dokter</th>
                                <th>Hari</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Antrian</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT
                            dp.id,
                            dp.id_pasien,
                            dp.no_antrian,
                            p.nama_poli,
                            d.nama_dokter,
                            jp.hari,
                            jp.jam_mulai,
                            jp.jam_selesai,
                            pr.id as id_periksa,
                            pr.tgl_periksa,
                            pr.catatan,
                            pr.biaya_periksa
                        FROM daftar_poli dp
                        JOIN jadwal_periksa jp ON dp.id_jadwal = jp.id
                        JOIN dokter d ON jp.id_dokter = d.id
                        JOIN poli p ON d.id_poli = p.id
                        LEFT JOIN periksa pr ON dp.id = pr.id_daftar_poli
                        WHERE dp.id_pasien = $pasien_id
                        ORDER BY
                            CASE
                                WHEN pr.tgl_periksa IS NULL THEN 0
                                ELSE 1
                            END,
                            dp.id DESC";
                            $no = 1;
                            $resultPendaftaran = mysqli_query($mysqli, $sql);
                            while ($row = mysqli_fetch_assoc($resultPendaftaran)) {
                                ?>
                                <tr class="text-center">
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $row['nama_poli']; ?></td>
                                    <td><?php echo $row['nama_dokter'] ?></td>
                                    <td><?php echo $row['hari'] ?></td>
                                    <td><?php echo $row['jam_mulai'] ?></td>
                                    <td><?php echo $row['jam_selesai'] ?></td>
                                    <td><?php echo $row['no_antrian'] ?></td>
                                    <td><?php echo ($row['tgl_periksa']) ? '<span class="badge badge-success">Sudah Diperiksa</span>' : '<span class="badge badge-warning">Belum Diperiksa</span>'; ?>
                                    </td>
                                    <td class='d-flex align-items-center justify-content-center'>
                                        <button type='button' class='btn btn-sm btn-primary edit-btn mx-1'
                                            data-toggle='modal' data-target='#myModal<?php echo $row['id']; ?>'>
                                            Detail
                                        </button>
                                        <!-- Modal Structure -->
                                        <div class='modal fade' id='myModal<?php echo $row['id']; ?>' tabindex="-1"
                                            role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>
                                            <div class='modal-dialog'>
                                                <div class='modal-content'>
                                                    <div class='modal-header bg-primary'>
                                                        <h5 class='modal-title' id='editModalLabel'>Detail Periksa</h5>
                                                        <button type='button text-white' class='close' data-dismiss='modal'
                                                            aria-label='Close'>
                                                            <span aria-hidden='true'>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <table class="table table-hover text-nowrap">
                                                            <?php if ($row['tgl_periksa']): ?>
                                                                <input type="hidden" name="id"
                                                                    value="<?php echo $row['id']; ?>">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-left">Nama Poliklinik</td>
                                                                        <td>:</td>
                                                                        <td class="text-left"><?php echo $row['nama_poli']; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-left">Nama Dokter</td>
                                                                        <td>:</td>
                                                                        <td class="text-left"><?php echo $row['nama_dokter']; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-left">Hari</td>
                                                                        <td>:</td>
                                                                        <td class="text-left"><?php echo $row['hari']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-left">Jam Praktek</td>
                                                                        <td>:</td>
                                                                        <td class="text-left">
                                                                            <?php echo $row['jam_mulai']; ?> -
                                                                            <?php echo $row['jam_selesai']; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-left">No Antrian</td>
                                                                        <td>:</td>
                                                                        <td class="text-left"><?php echo $row['no_antrian']; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-left">Status</td>
                                                                        <td>:</td>
                                                                        <td class="text-left">Sudah Diperiksa</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-left">Tanggal Periksa</td>
                                                                        <td>:</td>
                                                                        <td class="text-left"><?php echo $row['tgl_periksa']; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-left">Catatan Dokter</td>
                                                                        <td>:</td>
                                                                        <td class="text-left"><?php echo $row['catatan']; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-left">Obat</td>
                                                                        <td>:</td>
                                                                        <td class="text-left">
                                                                            <?php
                                                                            $query_obat = "SELECT o.nama_obat, o.kemasan
                                                                        FROM detail_periksa dp
                                                                        JOIN obat o ON dp.id_obat = o.id
                                                                        WHERE dp.id_periksa = {$row['id_periksa']}";
                                                                            $result_obat = mysqli_query($mysqli, $query_obat);
                                                                            while ($obat = mysqli_fetch_assoc($result_obat)) {
                                                                                echo "- {$obat['nama_obat']} ({$obat['kemasan']})<br>";
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-left">Biaya Periksa</td>
                                                                        <td>:</td>
                                                                        <td class="text-left">
                                                                            Rp
                                                                            <?php echo number_format($row['biaya_periksa'], 0, ',', '.'); ?>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="3">
                                                                            <div class="feedback-section mt-3">
                                                                                <h5>Feedback Pasien</h5>
                                                                                <?php
                                                                                // Check if feedback exists
                                                                                $query_feedback = "SELECT * FROM feedback_pasien WHERE id_periksa = {$row['id_periksa']}";
                                                                                $result_feedback = mysqli_query($mysqli, $query_feedback);
                                                                                $feedback = mysqli_fetch_assoc($result_feedback);

                                                                                if ($feedback) {
                                                                                    // Display existing feedback
                                                                                    echo "<div class='alert alert-info'>";
                                                                                    echo "<p><strong>Rating:</strong> ";
                                                                                    for ($i = 1; $i <= 5; $i++) {
                                                                                        if ($i <= $feedback['rating']) {
                                                                                            echo "★";
                                                                                        } else {
                                                                                            echo "☆";
                                                                                        }
                                                                                    }
                                                                                    echo "</p>";
                                                                                    echo "<p><strong>Komentar:</strong> " . htmlspecialchars($feedback['komentar']) . "</p>";
                                                                                    echo "<small class='text-muted'>Diberikan pada: " . date('d/m/Y H:i', strtotime($feedback['created_at'])) . "</small>";
                                                                                    echo "</div>";
                                                                                } else {
                                                                                    // Display feedback form
                                                                                    ?>
                                                                                    <form action="./dashboard/proses_feedback.php"
                                                                                        method="POST" class="feedback-form">
                                                                                        <input type="hidden" name="id_periksa"
                                                                                            value="<?php echo $row['id_periksa']; ?>">

                                                                                        <div class="form-group">
                                                                                            <label>Rating:</label>
                                                                                            <div class="rating">
                                                                                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                                                                                    <input type="radio" name="rating"
                                                                                                        value="<?php echo $i; ?>"
                                                                                                        id="star<?php echo $i; ?>"
                                                                                                        required>
                                                                                                    <label
                                                                                                        for="star<?php echo $i; ?>">☆</label>
                                                                                                <?php endfor; ?>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="form-group">
                                                                                            <label for="komentar">Komentar:</label>
                                                                                            <textarea class="form-control"
                                                                                                name="komentar" id="komentar"
                                                                                                rows="3" required></textarea>
                                                                                        </div>

                                                                                        <button type="submit"
                                                                                            class="btn btn-primary mt-2">Kirim
                                                                                            Feedback</button>
                                                                                    </form>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            <?php endif; ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>