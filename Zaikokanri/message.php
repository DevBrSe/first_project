<!DOCTYPE Html>
<html>
<head>
    <title>メッセージ</title>
    <link rel="stylesheet" href="Css/message.css">
</head>
<body>
    <h1>メッセージ</h1>
    <hr width="30%">
    <?php
        //データに接続する
        include "dataConnect.php";
        if(!isset($_GET["value"])){     //メッセージのvalueを確認
        }else{
            $id = trim($_GET["value"]); //メッセージを取得
            echo "<p>".$id."</p>";    //メッセージを出力
        }
    ?>
    <div class="modoru">
        <div class="backBtn">
            <form action="user_master_kanri.php" method="POST">
                <input id="backBtn" name="backBtn" type="submit" value="戻る">
            </form>
        <div>
    </div>
</body>
</html>
