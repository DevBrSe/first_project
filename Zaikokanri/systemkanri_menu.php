<?php
    session_start();
?>
<!DOCTYPE Html>
<html>
<head>
    <title>システム管理メニュー</title>
    <link rel="stylesheet" href="Css/systemkanri_menu.css">
</head>
<body>
    <h1>システム管理メニュー</h1>
    <hr width="35%">
    <div class="systemmenu">
        <ul class="menu">
            <li><a href="product_master_kanri.php">商品マスタ管理メニュー</a></li><br>
            <li><a href="product_type_kanri.php">商品種別マスタ管理メニュー</a></li><br>
            <li><a href="user_master_kanri.php">ユーザマスタ管理メニュー</a></li><br>
        </ul>
        <div class="backBtn">
            <form action="topmenu.php" method="POST">
                <input id="backBtn" type="submit" value="戻る"/>
            </form>
        </div>
    </div>
 
</body>
</html>
