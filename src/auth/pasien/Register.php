<?php
session_start();
include("../../config/koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = $_POST["nama_pasien"];
    $alamat = $_POST["alamat_pasien"];
    $no_ktp = $_POST["no_ktp"];
    $no_hp = $_POST["no_hp"];
    $password = $_POST["password"];

    // CASE 1
    $queryCheckExist = "SELECT * FROM pasien WHERE no_ktp = ?";
    $stmt = mysqli_prepare($mysqli, $queryCheckExist);
    mysqli_stmt_bind_param($stmt, "s", $no_ktp);
    mysqli_stmt_execute($stmt);
    $resultCheckExist = mysqli_stmt_get_result($stmt);


    if (mysqli_num_rows($resultCheckExist) > 0) {
        $row = mysqli_fetch_assoc($resultCheckExist);
        if ($row['nama'] != $nama) {
            ?>
            <script>
                alert(`Nama pasien tidak sesuai dengan nomor KTP yang terdaftar`)
            </script>
            <meta http-equiv='refresh' content='0; url=regsiter.php'>
            <?php
            die();
        }
        ;
        ?>
        <meta http-equiv='refresh' content='0; url=#'>
        <?php
        die();
    }

    // CASE 2
    $queryGetRm = "SELECT MAX(SUBSTRING(no_rm, 8)) as last_queue_number FROM pasien";
    $resultRm = mysqli_query($mysqli, $queryGetRm);

    // Check Query
    if (!$resultRm) {
        die("Query gagal: " . mysqli_error($mysqli));
    }

    // Get nomor antrian terakit dari hasil query
    $rowRm = mysqli_fetch_assoc($resultRm);
    $lastQueueNumber = $rowRm["last_queue_number"];

    // if table empty, set queue to 0
    $lastQueueNumber = $lastQueueNumber ? $lastQueueNumber : 0;
    $dateNow = date("Ym");
    $newQueueNumber = $lastQueueNumber + 1;
    $no_rm = $dateNow . "-" . str_pad($newQueueNumber, 3, '0', STR_PAD_LEFT);
    $queryInsert = "INSERT INTO pasien (nama_pasien, alamat_pasien, no_ktp, no_hp, no_rm, password) VALUES ('$nama', '$alamat', '$no_ktp', '$no_hp', '$no_rm', '$password')";

    if (mysqli_query($mysqli, $queryInsert)) {
        ?>
        <script>
            alert("Register Berhasil");
            window.location.href = "./Login.php";
        </script>
        <meta http-equiv='refresh' content='0; url=#'>
        <?php
        die();
    } else {
        echo "Error: " . $queryInsert . "<br>" . mysqli_error($mysqli);
        die();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #8B31BE;
            --secondary: #FF69B4;
            --bg-gradient: linear-gradient(135deg, #8B31BE20, #FF69B420);
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            background-attachment: fixed;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
            padding: 2.5rem;
            width: 100%;
            max-width: 600px;
            transition: all 0.3s;
        }

        .register-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(31, 38, 135, 0.25);
        }

        .logo-img {
            width: 120px;
            height: 120px;
            border-radius: 60px;
            padding: 5px;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            margin-bottom: 1.5rem;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(139, 49, 190, 0.2);
            border-radius: 15px;
            padding: 12px 20px;
            transition: all 0.3s;
            margin-bottom: 1rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(139, 49, 190, 0.2);
            border-color: var(--primary);
        }

        .btn-custom {
            background: rgba(139, 49, 190, 0.8);
            backdrop-filter: blur(4px);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 12px 35px;
            border-radius: 30px;
            transition: all 0.3s;
        }

        .btn-custom:hover {
            background: rgba(255, 105, 180, 0.8);
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(255, 105, 180, 0.4);
            color: white;
        }

        h3.gradient-text {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .input-group {
            gap: 1rem;
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="register-card">
            <div class="text-center mb-4">
                <img src="../../assets/logo.png" class="logo-img" alt="logo-healthcare">
                <h3 class="fw-bold gradient-text">Buat Akun</h3>
                <p class="text-muted">Masukkan informasi berdasarkan form</p>
            </div>
            <form method="POST" action="">
                <div class="mb-3">
                    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien"
                        placeholder="Nama Lengkap" required>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <input type="number" class="form-control" id="no_ktp" name="no_ktp" placeholder="NIK" required>
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Nomor Telepon"
                            required>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="date" class="form-control text-muted" id="date" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="alamat_pasien" name="alamat_pasien" placeholder="Alamat"
                        required>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" id="email" placeholder="Email" required>
                </div>
                <div class="row mb-4">
                    <div class="col">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                            required>
                    </div>
                    <div class="col">
                        <input type="password" class="form-control" id="re-password" placeholder="Konfirmasi Password"
                            required>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-custom">Daftar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>