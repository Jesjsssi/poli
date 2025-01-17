<!-- Modal Tambah Data Poli -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Data Poli</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form tambah data poli disini -->
                <form action="../admin/poli/TambahPoli.php" method="post">
                    <div class="form-group">
                        <label for="nama_poli">Nama Poli</label>
                        <input type="text" class="form-control" id="nama_poli" name="nama_poli" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Tambah Poli -->

<!-- Table Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 ">
            <div class="col-sm-6">
                <h1 class="m-0">Manajemen Poli</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
                    <li class="breadcrumb-item active">Poli</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end Table Header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- card -->
                <div class="card">

                    <!-- card header -->
                    <div class="card-header">
                        <h3 class="card-title">Data Poli</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-success float-right" data-toggle="modal"
                                data-target="#addModal">
                                Tambah
                            </button>
                        </div>
                    </div>
                    <!-- end card header -->
                    <!-- card body -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Poli</th>
                                    <th>Keterangan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include '../../../config/koneksi.php';
                                $query = "SELECT * FROM poli";
                                $no = 1;
                                $result = mysqli_query($mysqli, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row['nama_poli']; ?></td>
                                        <td><?php echo $row['keterangan'] ?></td>
                                        <td class='d-flex align-items-center justify-content-center'>
                                            <button type='button' class='btn btn-sm btn-warning edit-btn mx-1'
                                                data-toggle='modal'
                                                data-target='#myModal<?php echo $row['id']; ?>'>Edit</button>
                                            <a href='../admin/poli/HapusPoli.php?id=<?php echo $row['id']; ?>'
                                                class='btn btn-sm btn-danger mx-1'
                                                onclick='return confirm("Anda yakin ingin hapus?");'>Hapus</a>
                                            <!-- Modal Edit Poli  -->
                                            <div class='modal fade' id='myModal<?php echo $row['id']; ?>' tabindex="-1"
                                                role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog'>
                                                    <!-- Modal content-->
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <h5 class='modal-title' id='editModalLabel'>Edit Poli</h5>
                                                            <button type='button' class='close' data-dismiss='modal'
                                                                aria-label='Close'>
                                                                <span aria-hidden='true'>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <!-- Form edit data poli disini -->
                                                            <form action='../admin/poli/UpdatePoli.php' method='post'>
                                                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                                <div class='form-group'>
                                                                    <label for='nama_poli'>Nama Poli</label>
                                                                    <input type='text' class='form-control' id='nama_poli'
                                                                        name='nama_poli'
                                                                        value='<?php echo $row["nama_poli"]; ?>' required>
                                                                </div>
                                                                <div class='form-group'>
                                                                    <label for='keterangan'>Keterangan</label>
                                                                    <textarea class='form-control' id='keterangan'
                                                                        name='keterangan'
                                                                        required><?php echo $row["keterangan"]; ?></textarea>
                                                                </div>
                                                                <button type='submit' class='btn btn-primary'
                                                                    name='update'>Update</button>

                                                            </form>
                                                            <!-- end Modal Edit Poli -->
                                        </td>
                                    </tr>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                                }
                                mysqli_close($mysqli);
                                ?>

        </tbody>
        </table>
    </div>
    <!-- end Card Body -->
</div>
<!-- end card  -->
</div>
</div>
</div>
</div>