<?php
session_start();
include "database.php";

if(isset($_POST['pinjam'])) {
    $tgl_pinjam = date('Y-m-d H:i:s'); 
    $no_identitas = $_SESSION['no_identitas'];
    $id_login = $_SESSION['id']; 
    $kode_barang = mysqli_real_escape_string($connect, $_POST['kode_barang']);
    $jumlah = mysqli_real_escape_string($connect, $_POST['jumlah']);
    $keperluan = mysqli_real_escape_string($connect, $_POST['keperluan']);
    $query_check = "SELECT jumlah FROM barang WHERE kode_barang = '$kode_barang'";
    $result_check = mysqli_query($connect, $query_check);
    $row_check = mysqli_fetch_assoc($result_check);
    $jumlah_tersedia = $row_check['jumlah'];

    if ($jumlah_tersedia >= $jumlah) {
        $query_update = "UPDATE barang SET jumlah = jumlah - $jumlah WHERE kode_barang = '$kode_barang'";
        if (mysqli_query($connect, $query_update)) {
            $query_insert = "INSERT INTO peminjaman (no_identitas, kode_barang, jumlah, keperluan, tgl_pinjam, tgl_kembali, id_login) VALUES ('$no_identitas', '$kode_barang', '$jumlah', '$keperluan', '$tgl_pinjam', NULL, '$id_login')";
            if (mysqli_query($connect, $query_insert)) {
                echo "";
            } else {
                echo "Error: " . $query_insert . "<br>" . mysqli_error($connect);
            }
        } else {
            echo "Error: " . $query_update . "<br>" . mysqli_error($connect);
        }
    } else {
        echo "Jumlah barang yang diminta tidak tersedia.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Peminjaman</title>

    <!-- Custom fonts for this template-->
    <link href="resource/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="resource/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <div id="wrapper">

        <?php
        if ($_SESSION['status'] != "login") {
            header("location:login.php?msg=belum_login");
        } else {
            include("sidebar-member.php");
        }
        ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
                <ul class="navbar-nav ml-auto">
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['username']; ?></span>
                <img class="img-profile rounded-circle" src="resource/img/undraw_profile.svg" />
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
                </nav>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Peminjaman Barang</h1>
                    <form class="user" method="POST" action="peminjaman.php">
                    <div class="form-group">
                        <input type="hidden" class="form-control form-control-user" name="no_identitas" value="">
                    </div>

    <div class="form-group">
        <label for="kode_barang">Kode Barang</label>
        <select class="form-control form-control-user" name="kode_barang">
            <?php
                $barang_data = showdataBarang();
                foreach ($barang_data as $barang) {
                    echo "<option value=\"$barang[kode_barang]\">$barang[nama_barang]</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="jumlah">Jumlah dipinjam</label>
        <input type="number" class="form-control form-control-user" placeholder="Jumlah" name="jumlah">
    </div>
    <div class="form-group">
        <label for="keperluan">Keperluan</label>
        <input type="text" class="form-control form-control-user" placeholder="Keperluan" name="keperluan">
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control form-control-user" placeholder="Status" name="status">
    </div>
    <div class="form-group">
        <input type="date" class="form-control form-control-user" style="display:none;" name="tgl_pinjam">
    </div>
    <div class="form-group">
        <input type="date" class="form-control form-control-user" style="display:none;" name="tgl_kembali">
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control form-control-user" name="id_login">
    </div>
    <input type="submit" name="pinjam" class="btn btn-primary btn-user btn-block">
</form>

                </div>

            </div>

        </div>

        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>


    <!-- Bootstrap core JavaScript-->
    <script src="resource/vendor/jquery/jquery.min.js"></script>
    <script src="resource/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="resource/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="resource/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="resource/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="resource/js/demo/chart-area-demo.js"></script>
    <script src="resource/js/demo/chart-pie-demo.js"></script>

    

</body>

</html>
