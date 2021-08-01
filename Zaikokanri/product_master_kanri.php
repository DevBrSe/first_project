<!DOCTYPE Html>
<html>
<head>
    <title>商品管理メニュー</title> 
    <link rel="stylesheet" href="Css/product_master_kanri.css"> 
</head>
<body>
    <h1>商品マスタ管理メニュー</h1>
    <hr width="40%">
    <div class="product_master">
        <ul class="menu">
            <li><a href="addproduct_master.php">商品マスタ登録</a></li><br>
            <li><a href="product_master_detail.php">商品マスタ一覧表示</a></li><br>
        </ul>
        <div>
            <form action="systemkanri_menu.php" method="POST">
                <input id="backBtn" name="backBtn" type="submit" value="戻る">
            </form>
        <div>
    </div>
</body>
</html>
