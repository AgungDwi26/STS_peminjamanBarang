<?php
require_once('database.php');
session_start();
$_SESSION['status'] = ""; 
if ($_SESSION['status']=="login") { 
    header("location:index.php");
}else{  
    if (isset($_POST['masuk'])) {
        $username = $_POST['username'];
        if (checkLogin($_POST['username'], $_POST['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['status'] = "login";
            if ($_SESSION['role']=="admin") { 
                header("location:index.php");
            }if ($_SESSION['role']=="member"){
                header("location:index-member.php");
            }
        } else {
            header("location:login.php?msg=gagal");
        }
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

    <title>Login Page</title>

    <!-- Custom fonts for this template-->
    <link href="resource/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="resource/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="">

<div class="container">

<!-- Outer Row -->
<div class="row justify-content-center">

    <div class="col-md-6">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->                      
                    
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome to This Site!</h1>
                                <hr>
                            </div>
                            <form class="user" action="" method="post">
                                <div class="form-group">
                                    <h6 class="pl-3">Username:</h6>
                                    <input type="text" class="form-control form-control-user"
                                        id="exampleInputEmail" aria-describedby="emailHelp"
                                        placeholder="Enter Username..." name="username"> <!-- tambahkan atribut name -->
                                </div>
                                <div class="form-group">
                                    <h6 class="pl-3">Password:</h6>
                                    <input type="password" class="form-control form-control-user"
                                        id="exampleInputPassword" placeholder="Password" name="password"> <!-- tambahkan atribut name -->
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck">Remember
                                            Me</label>
                                    </div>
                                </div>
                                <input type="submit" value="Login" name="masuk" class="btn btn-primary btn-user btn-block">
                            </form>
                        </div>                     
            </div>
            <footer class="sticky-footer bg-white">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright &copy; Agung Dwi 2024</span>
        </div>
      </div>
    </footer>
        </div>
    </div>

</div>

</div>

    <!-- Bootstrap core JavaScript-->
    <script src="resource/vendor/jquery/jquery.min.js"></script>
    <script src="resource/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="resource/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="resource/js/sb-admin-2.min.js"></script>

</body>

</html>