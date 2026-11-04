<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['id_user'];
    $judul = trim($_POST['judul']);
    $id_kategori = $_POST['id_kategori'];
    $isi = trim($_POST['isi']);
    $is_anonim = isset($_POST['is_anonim']) ? 1 : 0;

    if (!empty($judul) && !empty($id_kategori) && !empty($isi)) {
        $sql = "INSERT INTO aspirasi (id_user, id_kategori, judul, isi, is_anonim, status, created_at) 
                VALUES (:id_user, :id_kategori, :judul, :isi, :is_anonim, 'Menunggu', NOW())";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_user' => $id_user,
            ':id_kategori' => $id_kategori,
            ':judul' => $judul,
            ':isi' => $isi,
            ':is_anonim' => $is_anonim
        ]);

        header("Location: dashboard.php?status=success");
        exit();
    } else {
        header("Location: aspirasi_tambah.php?status=empty");
        exit();
    }
}