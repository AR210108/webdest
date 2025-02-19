<?php

    $data = mysqli_connect("localhost", "root", "", "rinda_authentikasi");

    if (!$data){
        echo'gagal';
    }else{
        echo'berhasil';
    }
?>