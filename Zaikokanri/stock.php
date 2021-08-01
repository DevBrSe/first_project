<!DOCTYPE Html>
<html>
<head>
    <title>在庫管理メニュー</title>
    <link rel="stylesheet" href="Css/stock.css">
</head>
<body>
    <h1>在庫管理メニュー</h1>
    <hr width="45%">
    <div class="stockmenu">
        <ul>
            <li><a href="addproduct.php">在庫登録</a></li><br>
            <li><a href="product_detail.php">在庫一覧表示</a></li><br>
        </ul>
        <div>
            <form action="topmenu.php" method="POST">
                <input id="backBtn" name="backBtn" type="submit" value="戻る">
            </form>
        <div>
    </div>
</body>
</html>
