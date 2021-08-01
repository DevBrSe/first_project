<!DOCTYPE Html>
<html>
<head>
    <title>商品種別詳細</title>
    <link rel="stylesheet" href="Css/editproduct_type.css">
</head>
<body>
    <h1>商品種別詳細表示</h1>
    <hr width="35%">
    <?php
        //データに接続する
        include "dataConnect.php";
        if(!isset($_GET["shosaiId"])){             //詳細表示動作しない場合
        }else{
            $getUrl = trim($_GET["getUrl"]);
            $id = trim($_GET["shosaiId"]);         //商品種別IDを取得
            //商品種別ID,商品種別名、登録日をセレクト
            $select = "SELECT id,name,created_at FROM product_type_master WHERE id='$id'";  
            $data = $connect->query($select);       //クエリ実行
            foreach($data as $value){
                $id = $value["id"];                 //商品種別IDを取る
                $name = $value["name"];             //商品種別名を取る
                $created_at = $value["created_at"]; //登録日を取る
            }
        }
    ?>
    <div class="product_type_detail">
        <form>
            <dl>
                <dt>種別ID: </dt>
                <dd><?php echo $id; ?><dd>
            </dl>
            <dl>
                <dt>種別名: </dt>
                <dd><?php echo $name; ?><dd>
            </dl>
            <dl>
                <dt>登録日: </dt>
                <dd><?php echo $created_at; ?><dd>
            </dl>
        </form>
        <div class="backBtn">
            <a href="product_type_list.php?<?php echo $getUrl;?>">
                <input id="backBtn" name="backBtn" type="button" value="戻る">
            </a>
        </div>
    </div>
</body>
</html>
