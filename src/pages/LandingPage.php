<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Poliklinik</title>
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
            padding-top: 80px;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            min-height: 500px;
            padding: 120px 0 160px;
            margin-bottom: -80px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"><path fill="rgba(255, 255, 255, 0.1)" d="M45.3,-52.9C60.9,-40.9,77.3,-28.1,82.1,-11.2C86.9,5.7,80.2,26.8,67.2,41.8C54.2,56.8,35,65.7,15.3,69.5C-4.4,73.3,-24.6,72,-41.7,63.1C-58.8,54.2,-72.8,37.7,-77.6,18.1C-82.4,-1.5,-78,-24.1,-65.7,-39.7C-53.3,-55.3,-33,-63.8,-14.7,-64.5C3.7,-65.2,29.7,-64.9,45.3,-52.9Z" transform="translate(100 100)" /></svg>') no-repeat center center;
            opacity: 0.1;
        }

        .hero-img {
            max-width: 90%;
            height: auto;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.15));
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .container {
            position: relative;
            z-index: 2;
        }


        .login-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
            padding: 2.5rem;
            margin: 20px;
            transition: all 0.3s;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(31, 38, 135, 0.25);
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

        .profile-img {
            width: 130px;
            height: 130px;
            border-radius: 65px;
            padding: 5px;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            margin-bottom: 1.5rem;
        }

        .brand-name {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <span class="brand-name">
                <span style="color: var(--primary)">Poli</span><span style="color: var(--secondary)">Klinik</span>
            </span>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-6 text-white">
                    <h1 class="display-4 fw-bold mb-4">Selamat Datang di PoliKlinik</h1>
                    <p class="lead mb-4">Layanan kesehatan terpercaya dengan sistem reservasi online yang mudah dan
                        cepat.</p>
                </div>
            </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="login-card text-center">
                    <img src="src/assets/pasien.png" alt="pasien" class="profile-img mb-4">
                    <h3 class="mb-3">Login Pasien</h3>
                    <p class="text-muted">Akses layanan kesehatan dengan mudah sebagai pasien</p>
                    <a href="src/auth/pasien/login.php" class="btn btn-custom">Login Pasien</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="login-card text-center">
                    <img src="src/assets/dokter.png" alt="dokter" class="profile-img mb-4">
                    <h3 class="mb-3">Login Dokter</h3>
                    <p class="text-muted">Portal khusus untuk dokter mengelola jadwal praktik</p>
                    <a href="src/auth/dokter/login.php" class="btn btn-custom">Login Dokter</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>