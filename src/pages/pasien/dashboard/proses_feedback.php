<?php
session_start();
include_once("../../../config/koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$id_periksa = $_POST['id_periksa'];
$rating = $_POST['rating'];
$komentar = $_POST['komentar'];

// Validate input
if (!is_numeric($rating) || $rating < 1 || $rating> 5) {
    $_SESSION['error'] = "Rating tidak valid";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
    }

    // Prevent SQL injection
    $komentar = mysqli_real_escape_string($mysqli, $komentar);

    // Insert feedback
    $query = "INSERT INTO feedback_pasien (id_periksa, rating, komentar)
    VALUES ($id_periksa, $rating, '$komentar')";

    if (mysqli_query($mysqli, $query)) {
    $_SESSION['success'] = "Terima kasih atas feedback Anda!";
    } else {
    $_SESSION['error'] = "Terjadi kesalahan saat menyimpan feedback";
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
    }

    header("Location: dashboard.php");
    exit();
    ?>