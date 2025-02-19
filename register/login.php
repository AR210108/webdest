<?php
// Include the database connection file
require('koneksi.php');
// Initialize session
session_start();

$error = '';
$validate = '';

// Check if the session username is set and redirect if it is
if( isset($_SESSION['username']) ) header('Location: Rindawebdest/home.php');

// Check if the form is submitted
if( isset($_POST['submit']) ){
        
        // Sanitize input
        $username = stripslashes($_POST['username']);
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($con, $password);
       
        // Check if input fields are not empty
        if(!empty(trim($username)) && !empty(trim($password))){

            // Query the database for the username
            $query      = "SELECT * FROM users WHERE username = '$username'";
            $result     = mysqli_query($con, $query);
            $rows       = mysqli_num_rows($result);

            if ($rows != 0) {
                $hash   = mysqli_fetch_assoc($result)['password'];
                if(password_verify($password, $hash)){
                    $_SESSION['username'] = $username;
                    header('Location: /desatalagasari.com/login/admin/Admin/index.php');
                } else {
                    $error = 'Password salah !!';
                }
            } else {
                $error = 'Username tidak ditemukan !!';
            }
            
        } else {
            $error = 'Data tidak boleh kosong !!';
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<body>
<div class="login-wrapper">
    <div class="login-container"> <!-- New container for both form and image -->
        <div class="row no-gutters">
            <div class="col-12 col-md-6">
                <!-- Back icon button -->
                <a href="/desatalagasari.com/index.html" class="back-button">
                    <i class='bx bx-arrow-back'></i>
                </a>
                <form class="form-container" action="login.php" method="POST">
                    <h2 class="text-center">DESA TALAGASARI</h2>
                    <div class="form-group">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="InputPassword" name="password" placeholder="Masukkan Password">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">LOGIN</button>
                    <a href="/desatalagasari.com/login/register/register.php" class="btn btn-register btn-block">REGISTER</a>
                    <div class="text-center mt-2">
                        <a href="forgot_password.php" class="text-secondary">Forgot Password?</a>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-6 d-none d-md-block">
                <div class="login-image">
                    <img src="talagasari.jpg" class="img-fluid" alt="Talagasari Village Image">
                </div>
            </div>
        </div>
    </div>
</div>
    </section>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
