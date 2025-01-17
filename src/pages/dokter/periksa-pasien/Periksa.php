<?php
session_start();

$dokter_id = $_SESSION['id']
    ?>
<!-- Table Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 ">
            <div class="col-sm-6">
                <h1 class="m-0">Manajemen Periksa</h1>
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
<!-- end Table Header -->

<div class="card">
    <div class="card-header">
        <h3 class="card-title text-dark">List Pasien</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Hari</th>
                    <th>Tanggal Periksa</th>
                    <th>Keluhan</th>
                    <th>No Antrian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT DISTINCT PERIKSA.id, PERIKSA.id_daftar_poli, PASIEN.nama_pasien,
                PERIKSA.tgl_periksa, PERIKSA.catatan, PERIKSA.biaya_periksa,
                DAFTAR_POLI.keluhan, DAFTAR_POLI.no_antrian,
                JADWAL_PERIKSA.id_dokter, DOKTER.nama_dokter,
                POLI.nama_poli, JADWAL_PERIKSA.jam_mulai,
                JADWAL_PERIKSA.jam_selesai, JADWAL_PERIKSA.hari
                FROM periksa AS PERIKSA
                JOIN daftar_poli AS DAFTAR_POLI ON PERIKSA.id_daftar_poli = DAFTAR_POLI.id
                JOIN pasien AS PASIEN ON DAFTAR_POLI.id_pasien = PASIEN.id
                JOIN jadwal_periksa AS JADWAL_PERIKSA ON DAFTAR_POLI.id_jadwal = JADWAL_PERIKSA.id
                JOIN dokter AS DOKTER ON JADWAL_PERIKSA.id_dokter = DOKTER.id
                JOIN poli AS POLI ON DOKTER.id_poli = POLI.id
                LEFT JOIN detail_periksa AS DETAIL_PERIKSA ON PERIKSA.id = DETAIL_PERIKSA.id_periksa
                WHERE DOKTER.id = $dokter_id
                GROUP BY PERIKSA.id";

                $no = 1;
                $resultPasien = mysqli_query($mysqli, $sql);
                $rowCount = mysqli_num_rows($resultPasien);

                if ($rowCount > 0) {
                    while ($row = mysqli_fetch_assoc($resultPasien)) {
                        ?>
                        <tr class="text-center">
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['nama_pasien']; ?></td>
                            <td><?php echo $row['hari']; ?></td>
                            <td><?php echo $row['tgl_periksa'] ? $row['tgl_periksa'] : "Belum periksa"; ?></td>
                            <td><?php echo $row['keluhan'] ?></td>
                            <td><?php echo $row['no_antrian'] ?></td>

                            <td class='d-flex align-items-center justify-content-center'>
                                <?php
                                if ($row['tgl_periksa'] == null) {
                                    ?>
                                    <button type='button' class='btn btn-sm btn-primary edit-btn mx-1' data-toggle='modal'
                                        data-target='#myModal<?php echo $row['id']; ?>'>Periksa</button>
                                    <?php
                                } else {
                                    ?>
                                    <button type='button' class='btn btn-sm btn-warning edit-btn mx-1' data-toggle='modal'
                                        data-target='#editModal<?php echo $row['id']; ?>'>Edit</button>
                                    <?php
                                }
                                ?>

                                <!-- Modal Periksa -->
                                <?php
                                if ($row['tgl_periksa'] == null) {
                                    ?>
                                    <div class='modal fade' id='myModal<?php echo $row['id']; ?>' tabindex="-1" role='dialog'
                                        aria-labelledby='editModalLabel' aria-hidden='true'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title' id='editModalLabel'>Detail Periksa</h5>
                                                    <button type='button text-white' class='close' data-dismiss='modal'
                                                        aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                </div>
                                                <div class='modal-body'>
                                                    <form action='./periksa-pasien/UpdatePeriksa.php' class="text-left"
                                                        method='post' autocomplete="off">
                                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                        <div class='form-group'>
                                                            <label for='nama_pasien'>Nama Pasien</label>
                                                            <input type='text' class='form-control' id='nama_pasien'
                                                                name='nama_pasien' value='<?php echo $row["nama_pasien"]; ?>'
                                                                disabled required>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label for='tgl_periksa'>Tanggal Periksa</label>
                                                            <input type="datetime-local" class="form-control" id="tgl_periksa"
                                                                name="tgl_periksa" required>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label for='keluhan'>Keluhan</label>
                                                            <input type="text" class="form-control" name="keluhan" id="keluhan"
                                                                value="<?php echo $row['keluhan']; ?>" disabled />
                                                        </div>
                                                        <div class='form-group'>
                                                            <label for='no_antrian'>No Antrian</label>
                                                            <input type="text" class="form-control" name="no_antrian"
                                                                id="no_antrian" value="<?php echo $row['no_antrian']; ?>"
                                                                disabled />
                                                        </div>
                                                        <div class='form-group'>
                                                            <label for='catatan'>catatan</label>
                                                            <input type="text" class="form-control" id="catatan" name="catatan"
                                                                required>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label for='obat'>Obat</label>
                                                            <div id="obat-container<?php echo $row['id']; ?>">
                                                                <div class="d-flex mb-2">
                                                                    <select class="form-control mr-2" name="obat[]"
                                                                        onchange="calculateTotal(<?php echo $row['id']; ?>)">
                                                                        <option value="" data-harga="0">Pilih Obat</option>
                                                                        <?php
                                                                        $queryObat = "SELECT * FROM obat";
                                                                        $resultObat = mysqli_query($mysqli, $queryObat);
                                                                        while ($obat = mysqli_fetch_assoc($resultObat)) {
                                                                            ?>
                                                                            <option value="<?= $obat['id']; ?>"
                                                                                data-harga="<?= $obat['harga']; ?>">
                                                                                <?= $obat['nama_obat']; ?> - <?= $obat['kemasan']; ?> -
                                                                                Rp.<?= number_format($obat['harga'], 0, ',', '.'); ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <button type="button" class="btn btn-danger"
                                                                        onclick="removeObat(this, <?php echo $row['id']; ?>)">X</button>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                onclick="addObat(<?php echo $row['id']; ?>)">
                                                                Tambah Obat
                                                            </button>
                                                        </div>

                                                        <div class='form-group'>
                                                            <label for='total_biaya'>Total Biaya</label>
                                                            <input type="text" class="form-control"
                                                                id="total_biaya<?php echo $row['id']; ?>" name="total_biaya"
                                                                value="Rp. 150.000" readonly />
                                                        </div>
                                                        <button type='submit' class='btn btn-primary' name='update'>Periksa</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <!-- Modal Edit -->
                                    <div class='modal fade' id='editModal<?php echo $row['id']; ?>' tabindex="-1" role='dialog'
                                        aria-labelledby='editModalLabel' aria-hidden='true'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title' id='editModalLabel'>Edit Periksa</h5>
                                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                </div>
                                                <div class='modal-body'>
                                                    <form action='./periksa-pasien/EditPeriksa.php' class="text-left" method='post'
                                                        autocomplete="off">
                                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                        <div class='form-group'>
                                                            <label for='nama_pasien'>Nama Pasien</label>
                                                            <input type='text' class='form-control' id='nama_pasien'
                                                                name='nama_pasien' value='<?php echo $row["nama_pasien"]; ?>'
                                                                readonly>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label for='tgl_periksa'>Tanggal Periksa</label>
                                                            <input type="datetime-local" class="form-control" id="tgl_periksa"
                                                                name="tgl_periksa" value='<?php echo $row["tgl_periksa"]; ?>'
                                                                required>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label for='keluhan'>Keluhan</label>
                                                            <input type="text" class="form-control" name="keluhan" id="keluhan"
                                                                value="<?php echo $row['keluhan']; ?>" readonly>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label for='no_antrian'>No Antrian</label>
                                                            <input type="text" class="form-control" name="no_antrian"
                                                                id="no_antrian" value="<?php echo $row['no_antrian']; ?>" readonly>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label for='catatan'>Catatan</label>
                                                            <input type="text" class="form-control" id="catatan" name="catatan"
                                                                value='<?php echo $row["catatan"]; ?>' required>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label for='obat'>Obat</label>
                                                            <div id="obat-container<?php echo $row['id']; ?>">
                                                                <?php
                                                                // Get selected medicines
                                                                $querySelectedObat = "SELECT detail_periksa.id_obat, obat.nama_obat, obat.kemasan, obat.harga
                                               FROM detail_periksa
                                               JOIN obat ON detail_periksa.id_obat = obat.id
                                               WHERE detail_periksa.id_periksa = ?";
                                                                $stmtSelected = mysqli_prepare($mysqli, $querySelectedObat);
                                                                mysqli_stmt_bind_param($stmtSelected, "i", $row['id']);
                                                                mysqli_stmt_execute($stmtSelected);
                                                                $selectedObat = mysqli_stmt_get_result($stmtSelected);

                                                                // If no medicines selected, show empty selection
                                                                if (mysqli_num_rows($selectedObat) == 0) {
                                                                    ?>
                                                                    <div class="d-flex mb-2">
                                                                        <select class="form-control mr-2" name="obat[]"
                                                                            onchange="calculateTotal(<?php echo $row['id']; ?>)">
                                                                            <option value="" data-harga="0">Pilih Obat</option>
                                                                            <?php
                                                                            $queryObat = "SELECT * FROM obat";
                                                                            $resultObat = mysqli_query($mysqli, $queryObat);
                                                                            while ($obat = mysqli_fetch_assoc($resultObat)) {
                                                                                ?>
                                                                                <option value="<?= $obat['id']; ?>"
                                                                                    data-harga="<?= $obat['harga']; ?>">
                                                                                    <?= $obat['nama_obat']; ?> - <?= $obat['kemasan']; ?> -
                                                                                    Rp.<?= number_format($obat['harga'], 0, ',', '.'); ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <button type="button" class="btn btn-danger"
                                                                            onclick="removeObat(this, <?php echo $row['id']; ?>)">X</button>
                                                                    </div>
                                                                    <?php
                                                                } else {
                                                                    // Show selected medicines
                                                                    while ($selectedMed = mysqli_fetch_assoc($selectedObat)) {
                                                                        ?>
                                                                        <div class="d-flex mb-2">
                                                                            <select class="form-control mr-2" name="obat[]"
                                                                                onchange="calculateTotal(<?php echo $row['id']; ?>)">
                                                                                <option value="" data-harga="0">Pilih Obat</option>
                                                                                <?php
                                                                                $queryObat = "SELECT * FROM obat";
                                                                                $resultObat = mysqli_query($mysqli, $queryObat);
                                                                                while ($obat = mysqli_fetch_assoc($resultObat)) {
                                                                                    $selected = ($obat['id'] == $selectedMed['id_obat']) ? 'selected' : '';
                                                                                    ?>
                                                                                    <option value="<?= $obat['id']; ?>"
                                                                                        data-harga="<?= $obat['harga']; ?>" <?= $selected ?>>
                                                                                        <?= $obat['nama_obat']; ?> - <?= $obat['kemasan']; ?> -
                                                                                        Rp.<?= number_format($obat['harga'], 0, ',', '.'); ?>
                                                                                    </option>
                                                                                <?php } ?>
                                                                            </select>
                                                                            <button type="button" class="btn btn-danger"
                                                                                onclick="removeObat(this, <?php echo $row['id']; ?>)">X</button>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                                mysqli_stmt_close($stmtSelected);
                                                                ?>
                                                            </div>
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                onclick="addObat(<?php echo $row['id']; ?>)">
                                                                Tambah Obat
                                                            </button>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label for='total_biaya'>Total Biaya</label>
                                                            <input type="text" class="form-control"
                                                                id="total_biaya<?php echo $row['id']; ?>" name="total_biaya"
                                                                value="Rp. <?php echo number_format($row['biaya_periksa'], 0, ',', '.'); ?>"
                                                                readonly>
                                                        </div>
                                                        <button type='submit' class='btn btn-primary' name='update'>Update</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <script>
                    function addObat(rowId) {
                        const container = document.getElementById(`obat-container${rowId}`);
                        const obatDiv = document.createElement('div');
                        obatDiv.className = 'd-flex mb-2';

                        // Clone the first select element
                        const firstSelect = container.querySelector('select');
                        const newSelect = firstSelect.cloneNode(true);
                        newSelect.value = ''; // Reset selection

                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.className = 'btn btn-danger';
                        removeBtn.innerHTML = 'X';
                        removeBtn.onclick = function () { removeObat(this, rowId); };

                        obatDiv.appendChild(newSelect);
                        obatDiv.appendChild(removeBtn);
                        container.appendChild(obatDiv);
                    }

                    function removeObat(button, rowId) {
                        const container = document.getElementById(`obat-container${rowId}`);
                        if (container.children.length > 1) {
                            button.parentElement.remove();
                        }
                        calculateTotal(rowId);
                    }

                    function calculateTotal(rowId) {
                        const container = document.getElementById(`obat-container${rowId}`);
                        const selects = container.querySelectorAll('select');
                        let totalObat = 0;

                        selects.forEach(select => {
                            const selectedOption = select.options[select.selectedIndex];
                            const hargaObat = parseInt(selectedOption.getAttribute('data-harga')) || 0;
                            totalObat += hargaObat;
                        });

                        const biayaPeriksa = 150000;
                        const total = totalObat + biayaPeriksa;
                        document.getElementById(`total_biaya${rowId}`).value = `Rp. ${total.toLocaleString('id-ID')}`;
                    }
                </script>
            </tbody>
        </table>
    </div>
</div>