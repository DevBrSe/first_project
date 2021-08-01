<!DOCTYPE Html>
<html>
<head>
    <title>在庫詳細</title>
    <link rel="stylesheet" href="Css/product_shosai.css">
</head>
<body>
    <h1>在庫詳細表示</h1>
    <hr width="50%">
    <?php
        //データに接続する
        include "dataConnect.php";
        if(!isset($_GET["valueName"])){                         //在庫IDの取得を確認
        }else{
            $getUrl = $_GET["getUrl"];                          //在庫検索結果のURLを取得
            $id = trim($_GET["valueName"]);                     //在庫IDを取得
            $select = "SELECT * FROM stock WHERE id='$id'";     //在庫情報をセレクト
            $data = $connect->query($select);                   //クエリ実行
            foreach($data as $value){
                $product_id = $value["product_id"];             //商品IDを取る   
                $stock_quantity = $value["stock_quantity"];     //個数を取る
                $arrival_date = $value["arrival_date"];         //入荷日を取る
                $shelf_life_date = $value["shelf_life_date"];   //賞味期限を取る
                $is_deleted = $value["is_deleted"];             //削除フラッグを取る    
                $created_at = $value["created_at"];             //登録日を取る
                $updated_at = $value["updated_at"];             //更新日を取る
            }
            //商品IDに基づいて、商品情報をセレクト
            $selectProduct_master = "SELECT name, product_type_id, price FROM product_master WHERE  id='$product_id'";
            $dataProduct_master = $connect->query($selectProduct_master);    //クエリ実行
            foreach($dataProduct_master as $key){                            
                $name = $key["name"];                                        //商品名を取る
                $product_type_id = $key["product_type_id"];                  //種別IDを取る
                $price = $key["price"];                                      //価格を取る
            }
            //種別IDに基づいて、種別名をセレクト
            $selectProduct_type_master = "SELECT name FROM product_type_master WHERE id='$product_type_id'";
            $dateProduct_type_master = $connect->query($selectProduct_type_master); //クエリ実行
            $result = mysqli_fetch_array($dateProduct_type_master);                 //データの連想配列を取得
            $product_type_name = $result["name"];                                   //種別名を取る
        }
    ?>
    <div class="shosaiclass">
        <ul>
            <p><label>在庫ID：</label><?php if(isset($id)){echo $id;} ?></p>
            <p><label>種別ID：</label><?php if(isset($product_type_id)){echo $product_type_id;} ?></p>
            <p><label>種別名：</label><?php if(isset( $product_type_name)){echo  $product_type_name;} ?></p>
            <p><label>商品ID：</label><?php if(isset($product_id)){echo $product_id;}?></p>
            <p><label>商品名：</label><?php if(isset($name)){echo $name;}?></p>
            <p><label>価格：</label><?php if(isset($price)){echo "¥".$price;}?></p>
            <p><label>個数：</label><?php if(isset($stock_quantity)){echo $stock_quantity;}?></p>
            <p><label>入荷日：</label><?php if(isset($arrival_date)){echo $arrival_date;}?></p>
            <p><label>賞味期限：</label><?php if(isset($shelf_life_date)){echo $shelf_life_date;}?></p>
            <p><label>登録日：</label><?php if(isset($created_at)){echo $created_at;}?></p>
            <p><label>更新日：</label><?php if(isset($updated_at)){echo $updated_at;}?></p>
            <p><label>削除済：</label><input id="is_deleted" name="is_deleted" disabled type="checkbox" <?php if(isset($is_deleted) && $is_deleted==1){echo "checked";} ?>/></p>
        </ul>
        <div class="backBtn">
            <a href="product_detail.php?<?php echo  $getUrl; ?>">
                <input id="backBtn" name="backBtn" type="button" value="戻る"/> 
            </a>
        </div>
    </div>
</body>
</html>
