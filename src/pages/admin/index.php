<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>ADMIN - Poliklinik</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../../modules/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../modules/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("../../components/navigation/navbar/Navbar.php") ?>
        <!-- Sidebar -->
        <?php include("../../components/navigation/side-bar/SideBar.php") ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div id="content"></div>
            </div>
        </div>

        <!-- Main Footer -->
        <?php include("../../components/navigation/footer/Footer.php") ?>
    </div>

    <!-- AdminLTE App -->
    <script src="../../../modules/dist/js/adminlte.min.js"></script>
    <!-- jQuery -->
    <script src="../../../modules/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="../../../modules/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#content').load('../../components/main-content/MainContent.php')
            $('.menu').click(function (e) {
                e.preventDefault();
                var menu = $(this).attr('id');

                if (menu == "menuDashboard") {
                    $('.nav-link').removeClass('active')
                    $(this).addClass('active')
                    $('#content').load('../../components/main-content/MainContent.php');
                } else if (menu == "menuDokter") {
                    $('.nav-link').removeClass('active')
                    $(this).addClass('active')
                    $('#content').load('../../pages/admin/dokter/dokter.php');
                } else if (menu == "menuObat") {
                    $('.nav-link').removeClass('active')
                    $(this).addClass('active')
                    $('#content').load('../../pages/admin/obat/Obat.php');
                } else if (menu == "menuPasien") {
                    $('.nav-link').removeClass('active')
                    $(this).addClass('active')
                    $('#content').load('../../pages/admin/pasien/pasien.php');
                } else if (menu == "menuPasien") {
                    $('.nav-link').removeClass('active')
                    $(this).addClass('active')
                    $('#content').load('../../pages/admin/pasien/pasien.php');
                    // } else if (menu == "menuJadwalPeriksa") {
                    //     $('.nav-link').removeClass('active')
                    //     $(this).addClass('active')
                    //     $('#content').load('../../pages/admin/jadwal-periksa/JadwalPeriksa.php');
                } else if (menu == "menuPoli") {
                    $('.nav-link').removeClass('active')
                    $(this).addClass('active')
                    $('#content').load('../../pages/admin/poli/poli.php');
                } else if (menu == "menuProfilPasien") {
                    $('.nav-link').removeClass('active')
                    $(this).addClass('active')
                    $('#content').load('../../pages/pasien/profil/profil.php');
            })
        })
    </script>

</body>

</html>