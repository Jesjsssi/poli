<?php
session_start();
include_once("../../config/koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $no_ktp = $_POST["no_ktp"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM pasien WHERE no_ktp = ?";
    $result = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($result, "s", $no_ktp);
    mysqli_stmt_execute($result);
    $CheckResult = mysqli_stmt_get_result($result);
    if ($CheckResult->num_rows <= 0) {
        ?>
        <script>
            alert(`Maaf NIK atau password anda salah`)
        </script>
        <meta http-equiv='refresh' content='0;'>
        <?php
        die();
    } else {
        $row = mysqli_fetch_assoc($CheckResult);
        if ($row['no_ktp'] == $no_ktp && $row['password'] == $password) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            $_SESSION["username"] = $row["nama_pasien"];
            $_SESSION["no_rm"] = $row["no_rm"];
            $_SESSION["akses"] = "pasien";
            ?>
            <script>
                alert(`Login Berhasil`)
            </script>
            <meta http-equiv='refresh' content='0; url=../../../src/pages/pasien/index.php'>
            <?php
            die();
        }
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Pasien</title>
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

        .login-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
            transition: all 0.3s;
        }

        .login-card:hover {
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

        .link-custom {
            color: var(--primary);
            text-decoration: none;
            transition: all 0.3s;
        }

        .link-custom:hover {
            color: var(--secondary);
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="text-center mb-4">
                <img src="../../assets/logo.png" class="logo-img" alt="logo-healthcare">
                <h3 class="fw-bold" style="background: linear-gradient(45deg, var(--primary), var(--secondary));
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;">Login Pasien</h3>
            </div>
            <form method="POST" action="">
                <div class="mb-4">
                    <input type="number" class="form-control mb-3" id="no_ktp" name="no_ktp" placeholder="Masukkan NIK"
                        required>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                        required>
                </div>
                <p class="text-muted small mb-4">Gunakan akun yang sudah terdaftar untuk melakukan login</p>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="./Register.php" class="link-custom">Buat Akun</a>
                    <button type="submit" class="btn btn-custom">Login</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>