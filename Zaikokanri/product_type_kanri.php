<!DOCTYPE Html>
<html>
<head>
    <title>商品種別管理</title>
    <link rel="stylesheet" href="Css/product_type_kanri.css">
</head>
<body>
    <h1>商品種別マスタ管理メニュー</h1>
    <hr width="50%">
    <div class="shubetsumenu">
        <ul class="menu">
            <li><a href="addproduct_type.php">商品種別マスタ登録</a></li><br>
            <li><a href="product_type_list.php">商品種別マスタ一覧表示</a></li><br>
        </ul>
        <div class="backBtn">
            <form action="systemkanri_menu.php" method="POST">          
                <input id="backBtn" name="backBtn" type="submit" value="戻る">
            </form>  
        </div>
    </div>

</body>
</html>
