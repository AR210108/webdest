<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DESA TALAGASARI</title>
    <link rel="stylesheet" href="style.css">
    <link href="img/logo_cms.png" rel="icon">
</head>

<body>
    <div class="container">
        <div class="login">
            <form method="post" action="cek_login.php">
                <h1>DESA TALAGASARI</h1>
                <hr>
                <p>LOGIN</p>
                <?php
                    if(isset($_GET['pesan'])){
                    if($_GET['pesan'] == "gagal"){
                        echo "Login gagal! username dan password salah!";
                    }else if($_GET['pesan'] == "logout"){
                        echo "Anda telah berhasil logout";
                    }else if($_GET['pesan'] == "belum_login"){
                        echo "Anda harus login untuk mengakses halaman admin";
                    }
                 }
                 ?>
                <input type="text" name="username" placeholder="Masukkan username">
                <input type="password" name="password" placeholder="Masukkan Password">
                <button type="submit" value="LOGIN">LOGIN</button>
                <div class="form-footer mt-2">
    <div onclick="location.href='/desatalagasari.com/register/register.php'" class="btn-login">REGISTER</div>
</div>

                
                <p>
                    <a href="#">Forgot Password?</a>
                </p>
            </form>
        </div>
        <div class="right">
            <img src="img/talagasari.jpg" alt="">
        </div>
    </div>
</body>

</html>