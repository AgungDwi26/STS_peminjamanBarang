<?php
session_start();
include "database.php";

if(isset($_POST['kembali'])) {
    $id_peminjaman = $_POST['id'];
    $tgl_kembali = date('Y-m-d H:i:s'); 
    $query_peminjaman = "SELECT * FROM peminjaman WHERE id = $id_peminjaman";
    $result_peminjaman = mysqli_query($connect, $query_peminjaman);
    $row_peminjaman = mysqli_fetch_assoc($result_peminjaman);
    $kode_barang = $row_peminjaman['kode_barang'];
    $jumlah_dikembalikan = $row_peminjaman['jumlah'];
    $query_update_peminjaman = "UPDATE peminjaman SET tgl_kembali = '$tgl_kembali', status = 'Dikembalikan' WHERE id = $id_peminjaman";
    $query_update_barang = "UPDATE barang SET jumlah = jumlah + $jumlah_dikembalikan WHERE kode_barang = '$kode_barang'";
    mysqli_begin_transaction($connect);
    $error = false;

    if (!mysqli_query($connect, $query_update_peminjaman) || !mysqli_query($connect, $query_update_barang)) {
        $error = true;
    }

    if ($error) {
        mysqli_rollback($connect);
        echo "Error: Pengembalian barang gagal.";
    } else {
        mysqli_commit($connect);
        header("location:datapeminjaman-member.php");
    }
}
?>
