<!DOCTYPE Html>
<html>
<head>
    <title>ユーザマスタ管理</title>
    <link rel="stylesheet" href="Css/user_master_kanri.css">
</head>
<body>
    <h1>ユーザマスタ管理メニュー</h1>
    <hr width="50%">
    <div class="userkanri">
        <ul class="usermaster">
            <li><a href="addusers.php">ユーザマスタ登録</a></li><br>
            <li><a href="userichiran.php">ユーザマスタ一覧表示</a></li><br>
        </ul>
        <div class="backBtn">
            <form action="systemkanri_menu.php" method="POST">
                <input id="backBtn" type="submit" value="戻る"/>
            </form>
        </div>
    </div>
</body>
</html>
