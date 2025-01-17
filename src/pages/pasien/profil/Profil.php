<?php
session_start();
include_once("../../../config/koneksi.php");
$pasien_id = $_SESSION['id'];
?>
<!-- Profile Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Profil Pasien</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#" id="menuHome">Home</a></li>
                    <li class="breadcrumb-item active">Profil</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php
// Fetch pasien data
$sql = "SELECT PASIEN.* FROM pasien AS PASIEN WHERE PASIEN.id = $pasien_id";
$result = mysqli_query($mysqli, $sql);
$pasien = mysqli_fetch_assoc($result);
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title text-dark">Informasi Pasien</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th>Nama</th>
                        <td><?php echo $pasien['nama_pasien']; ?></td>
                    </tr>
                    <tr>
                        <th>No. RM</th>
                        <td><?php echo $pasien['no_rm']; ?></td>
                    </tr>
                    <tr>
                        <th>No. KTP</th>
                        <td><?php echo $pasien['no_ktp']; ?></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><?php echo $pasien['alamat_pasien']; ?></td>
                    </tr>
                    <tr>
                        <th>No. Telepon</th>
                        <td><?php echo $pasien['no_hp']; ?></td>
                    </tr>
                </table>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
                    Edit Profil
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profile -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Profil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateProfilForm">
                    <input type="hidden" name="id" value="<?php echo $pasien_id; ?>">
                    <div class="form-group">
                        <label for="nama_pasien">Nama</label>
                        <input type="text" class="form-control" id="nama_pasien" name="nama_pasien"
                            value="<?php echo $pasien['nama_pasien']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no_ktp">No. KTP</label>
                        <input type="text" class="form-control" id="no_ktp" name="no_ktp"
                            value="<?php echo $pasien['no_ktp']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat_pasien">Alamat</label>
                        <textarea class="form-control" id="alamat_pasien" name="alamat_pasien"
                            required><?php echo $pasien['alamat_pasien']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No. Telepon</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp"
                            value="<?php echo $pasien['no_hp']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#updateProfilForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: './profil/UpdatePasien.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    alert("Profil berhasil diperbarui!");
                    $('#editModal').modal('hide');
                    $('#content').load('./profil/index.php');
                },
                error: function () {
                    alert("Terjadi kesalahan saat memperbarui profil!");
                }
            });
        });
    });
</script>