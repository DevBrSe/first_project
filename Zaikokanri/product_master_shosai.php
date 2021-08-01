<!DOCTYPE Html>
<html>
<head>
    <title>商品詳細</title>
    <link rel="stylesheet" href="Css/product_master_shosai.css">
</head>
<body>
    <h1>商品マスタ詳細表示</h1>
    <hr width="50%">
    <?php
        //データに接続する
        include "dataConnect.php";
        if(!isset($_GET["productId"])){               //商品IDの取得を確認
        }else{
            $getUrl = $_GET["getUrl"];                //商品検索結果のURLを取得
            $id = trim($_GET["productId"]);           //商品IDを取得
            $select = "SELECT * FROM product_master WHERE id = '$id'";  //商品情報をセレクト
            $data = $connect->query($select);                           //クエリ実行
            foreach($data as $value){
                $product_id = $value["id"];                             //商品IDを取る
                $product_type_id = $value["product_type_id"];           //商品種別IDを取る
                $name = $value["name"];                                 //商品名を取る
                $price = $value["price"];                               //価格を取る
                $shelf_life_days = $value["shelf_life_days"];           //賞味期限日数を取る
                $created_at = $value["created_at"];                     //登録日を取る
                $updated_at = $value["updated_at"];                     //更新日を取る
                $is_deleted = $value["is_deleted"];                     //削除フラッグを取る
            }
            //商品種別IDによって、商品種別名をセレクト
            $selproduct_type_name = "SELECT name FROM product_type_master WHERE id = '$product_type_id'";
            $dataproduct_type_name = $connect->query($selproduct_type_name);    //クエリ実行
            foreach($dataproduct_type_name as $value){
                $product_type_name = $value["name"];                            //商品種別名を取る
            }
        }
    ?>
    <div class="backBtn_class">
        <div class="shosaihyouji">
            <ul>
                <p><label>商品ID :</label><?php if(isset($product_id)){echo $product_id;}?></p>
                <p><label>商品種別ID :</label><?php if(isset($product_type_id)){echo $product_type_id;} ?></p>
                <p><label>商品種別名 :</label><?php if(isset($product_type_name)){echo $product_type_name;} ?></p>
                <p><label>商品名 :</label><?php if(isset($name)){echo $name;} ?></p>
                <p><label>単価 :</label><?php if(isset($price)){echo "¥".$price;} ?></p>
                <p><label>賞味期限日数 :</label><?php if(isset($shelf_life_days)){echo $shelf_life_days."日";} ?></p>
                <p><label>登録日 :</label><?php if(isset($created_at )){echo $created_at;} ?></p>
                <p><label>更新日 :</label><?php if(isset($updated_at)){echo $updated_at;} ?></p>
                <p><label>削除済 :</label><input type="checkbox" disabled <?php if(isset($is_deleted)){if($is_deleted==1){echo "checked";}} ?>/></p>
            </ul>
        </div>
        <a href="product_master_detail.php?<?php if(isset($getUrl)){echo $getUrl;}?>">
            <input id="backBtn" name="backBtn" type="button" value="戻る">
        </a>
    </div>
</body>
</html>
