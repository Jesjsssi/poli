<?php
session_start();

$dokter_id = $_SESSION['id']
    ?>


<!-- Table Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manajemen Riwayat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
                    <li class="breadcrumb-item active">Periksa</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php
// Get current doctor's ID from session
$id_dokter = $_SESSION['id'];

// Query untuk mengambil daftar pasien
$sqlRiwayat = "SELECT DISTINCT
    PASIEN.id,
    PASIEN.nama_pasien,
    PASIEN.alamat_pasien,
    PASIEN.no_hp,
    PASIEN.no_ktp,
    PASIEN.no_rm
FROM pasien AS PASIEN
JOIN daftar_poli AS DAFTAR_POLI ON PASIEN.id = DAFTAR_POLI.id_pasien
JOIN jadwal_periksa AS JADWAL ON DAFTAR_POLI.id_jadwal = JADWAL.id
JOIN periksa AS PERIKSA ON DAFTAR_POLI.id = PERIKSA.id_daftar_poli
WHERE JADWAL.id_dokter = ?
ORDER BY PASIEN.nama_pasien ASC";

$stmt = mysqli_prepare($mysqli, $sqlRiwayat);
mysqli_stmt_bind_param($stmt, "i", $id_dokter);
mysqli_stmt_execute($stmt);
$resultRiwayat = mysqli_stmt_get_result($stmt);
?>

<!-- Riwayat Pasien Section -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title text-dark">Riwayat Pasien</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Alamat Pasien</th>
                    <th>No HP</th>
                    <th>No KTP</th>
                    <th>No RM</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($rowRiwayat = mysqli_fetch_assoc($resultRiwayat)) {
                    ?>
                    <tr class="text-center">
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $rowRiwayat['nama_pasien']; ?></td>
                        <td><?php echo $rowRiwayat['alamat_pasien']; ?></td>
                        <td><?php echo $rowRiwayat['no_hp']; ?></td>
                        <td><?php echo $rowRiwayat['no_ktp']; ?></td>
                        <td><?php echo $rowRiwayat['no_rm']; ?></td>
                        <td>
                            <button type='button' class='btn btn-sm btn-info view-history'
                                data-id='<?php echo $rowRiwayat['id']; ?>'
                                data-nama='<?php echo $rowRiwayat['nama_pasien']; ?>'>
                                Detail Riwayat
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Detail Riwayat -->
<div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historyModalLabel">Riwayat Pemeriksaan Pasien: <span id="namaPasien"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal Periksa</th>
                                <th>Keluhan</th>
                                <th>Catatan</th>
                                <th>Obat</th>
                                <th>Biaya</th>
                            </tr>
                        </thead>
                        <tbody id="riwayatDetail">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Add this JavaScript code at the end of your file -->
<script>
    $(document).ready(function () {
        $('.view-history').click(function () {
            var id_pasien = $(this).data('id');
            var nama_pasien = $(this).data('nama');

            // Set nama pasien in modal title
            $('#namaPasien').text(nama_pasien);

            // Show modal
            $('#historyModal').modal('show');

            // Load riwayat data
            $.ajax({
                url: './riwayat-periksa/get_riwayat.php',
                type: 'POST',
                data: {
                    id_pasien: id_pasien,
                    id_dokter: <?php echo $id_dokter; ?>
                },
                success: function (response) {
                    $('#riwayatDetail').html(response);
                },
                error: function () {
                    $('#riwayatDetail').html('<tr><td colspan="5" class="text-center">Error loading data</td></tr>');
                }
            });
        });
    });


    // Function untuk menutup modal
    function closeModal() {
        $('#historyModal').modal('hide');
    }

    // Event handler untuk tombol tutup
    $(document).ready(function () {
        // Handler untuk tombol close di modal
        $('.btn-close-modal').click(function () {
            closeModal();
        });

        // Handler untuk tombol close (×) di header modal
        $('.modal .close').click(function () {
            closeModal();
        });
    });
</script>