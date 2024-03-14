<?php

    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "sts_agung";
    $connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name) or die("Gagal terhubung dengan Database: " . mysqli_connect_error());


    function checkLogin($username, $password){
        global $connect; 
        $uname = mysqli_real_escape_string($connect, $username);
        $upass = mysqli_real_escape_string($connect, $password);    
        $hasil = mysqli_query($connect,"SELECT * FROM user WHERE username='$uname' and password=md5('$upass')");
        $cek = mysqli_num_rows($hasil);
        if($cek > 0 ){
            $query = mysqli_fetch_array($hasil);
            $_SESSION['id'] = $query['id'];
            $_SESSION['username'] = $query['username'];
            $_SESSION['role'] = $query['role'];
            $_SESSION['no_identitas'] = $query['no_identitas'];
            return true;        
        }
        else {
            return false;
        }    
    }


    function showdataUser()
    {
        global $connect;    
        $hasil=mysqli_query($connect,"SELECT id, no_identitas, nama, status, username, role FROM user");
        $rows=[];
        while($row = mysqli_fetch_assoc($hasil))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    function showdataBarang()
    {
        global $connect;    
        $hasil=mysqli_query($connect,"SELECT id, kode_barang, nama_barang, kategori, merk, jumlah FROM barang");
        $rows=[];
        while($row = mysqli_fetch_assoc($hasil))
        {
            $rows[] = $row;
        }
        return $rows;

    }

    function showdataPeminjaman()
    {
        global $connect;    
        $hasil=mysqli_query($connect,"SELECT * FROM peminjaman");
        $rows=[];
        while($row = mysqli_fetch_assoc($hasil))
        {
            $rows[] = $row;
        }
        return $rows;
    }



    function editData($tablename, $id)
    {
        global $connect;
        $id = mysqli_real_escape_string($connect, $id);
        $hasil=mysqli_query($connect,"SELECT * FROM $tablename WHERE id='$id'");
        return $hasil;
    }

    function deleteData($tablename,$id)
    {
        global $connect;
        $id = mysqli_real_escape_string($connect, $id);
        $hasil=mysqli_query($connect,"DELETE FROM $tablename WHERE id='$id'");
        return $hasil;
    }

    function getBarangSeringDipinjam($limit = 5) {
        global $connect;
    
        $query = "SELECT kode_barang, COUNT(*) as jumlah_pinjam FROM peminjaman GROUP BY kode_barang ORDER BY jumlah_pinjam DESC LIMIT $limit";
        $result = mysqli_query($connect, $query);
    
        $barang_sering_dipinjam = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $barang_sering_dipinjam[] = $row;
        }
    
        return $barang_sering_dipinjam;
    }
?>
