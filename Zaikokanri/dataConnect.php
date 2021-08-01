<?php
    $server = "localhost";      //サーバー名
    $dataname = "products_db";  //データ名
    $username = "root";         //ユーザ名
    $password = "";             //パースワード
    //データに接続する
    $connect = new mysqli($server, $username, $password, $dataname);
?>