<!-- File: ./profil/index.php -->
<?php
session_start();
include_once("../../../config/koneksi.php");
$dokter_id = $_SESSION['id'];
?>
<!-- Profile Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Profil Dokter</h1>
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
// Fetch dokter data
$sql = "SELECT DOKTER.* FROM dokter AS DOKTER WHERE DOKTER.id = $dokter_id";
$result = mysqli_query($mysqli, $sql);
$dokter = mysqli_fetch_assoc($result);
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title text-dark">Informasi Dokter</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th>Nama</th>
                        <td><?php echo $dokter['nama_dokter']; ?></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><?php echo $dokter['alamat_dokter']; ?></td>
                    </tr>
                    <tr>
                        <th>No. Telepon</th>
                        <td><?php echo $dokter['no_hp']; ?></td>
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
                    <input type="hidden" name="id" value="<?php echo $dokter_id; ?>">
                    <div class="form-group">
                        <label for="nama_dokter">Nama</label>
                        <input type="text" class="form-control" id="nama_dokter" name="nama_dokter"
                            value="<?php echo $dokter['nama_dokter']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat_dokter">Alamat</label>
                        <textarea class="form-control" id="alamat_dokter" name="alamat_dokter"
                            required><?php echo $dokter['alamat_dokter']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No. Telepon</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp"
                            value="<?php echo $dokter['no_hp']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#updateProfilForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: './profil/UpdateDokter.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert("Profil berhasil diperbarui!");
                $('#editModal').modal('hide');
                $('#content').load('./profil/index.php');
            },
            error: function() {
                alert("Terjadi kesalahan saat memperbarui profil!");
            }
        });
    });
});
</script>