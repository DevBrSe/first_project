<!DOCTYPE Html>
<html>
<head>
    <title>商品更新</title>
    <style>
        body{
            background-color:lightcyan;
        }
        h1,h2,h3,h5{
            text-align: center;
        }
        h1{
            color:crimson;
        }
        h2{
            margin-left: 50px;
            color:navy;
        }
        h3{
            color:purple;
        }
        h5{
            color: red;
        }
        input{
            margin: 5px;
            width: 300px;
            height: 30px;
            font-size: 20px;
        }
        form dl dt{
            width: 150px;
            float: left;
            margin-top: 20px;
            margin-right: 10px;
            color:mediumblue;
        }
        #is_deleted{
            width: 25px;
            height: 15px;
            margin-left: -1px;
            margin-top: 20px;
        }
        .koshinclass{
            width: 630px;
            margin:auto;
        }
        #updateBtn{
            width: 100px;
            height: 50px;
            border-radius: 2px;
            font-size: 20px;
            margin-top: 50px;
            margin-left: 165px;
            background-color:royalblue;
            color:white;
        }
        .backBtn{
            margin-left: 370px;
            margin-top: -58px;
        }
        #backBtn{
            width: 100px;
            height: 50px;
            border-radius: 2px;
            font-size: 20px;
            background-color:royalblue;
            color:white;
        }
        .modal_message{
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }
        .kakuninMsg{
            border: 1px solid brown;
            position: absolute;
            width: 400px;
            height: 120px;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border-radius: 6px;
        }
        .closeBtn{
            float: right;
            margin-right: 5px;
            cursor: pointer;
        }
        p{
            color: navy;
            text-align: center;
            font-size: 20px;
        }
        .modal_class1{
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            display: none;
        }
        .kakuninMsg1{
            border: 1px solid brown;
            position: absolute;
            width: 450px;
            height: 180px;
            top: 40%;
            left: 50%;
            transform: translate(-50%,-50%);
            background-color: white;
            border-radius: 6px;
        }
        #okBtn1,#cancelBtn{
            width: 70px;
            height: 35px;
            border-radius: 6px;
            background-color:royalblue;
            color:white;
        }
        #cancelBtn{
            margin-left: 50px;
        }
        .closeBtn1{
          width: 250px;
          margin: auto;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function updateEvent(){
            var price = document.getElementById("price").value;
            var shelf_life_days = document.getElementById("shelf_life_days").value;
            if(price == "" || shelf_life_days == ""){              
            }else{
                var productId = document.getElementById("productId").value;
                document.getElementById("checkvalue").innerHTML = "商品ID("+productId+")、";
                $('.modal_class1').fadeIn(0.001);
            }      
        }
        $(document).on('click','#okBtn1',function(){
            document.getElementById("updateform").submit();
            $("#checksubmit").val();
            $('.modal_class1').fadeOut(0.0001);
        });
        $(document).on('click','.closeBtn',function(){
            $('.modal_message').fadeOut(0.0001);
        });
        $(document).on('click','#cancelBtn',function(){
            $('.modal_class1').fadeOut(0.0001);
        });
    </script></script>
</head>
<body>
    <h1>商品マスタ更新</h1>
    <hr width="50%">
    <?php
        //データに接続する   
        include "dataConnect.php";
        if(!isset($_GET["productId"])){               //詳細表示画面から商品IDを取得する確認
        }else{
            $getUrl = $_GET["getUrl"];                //商品検索結果のURLを取得
            $id = trim($_GET["productId"]);           //商品IDを取得
            $select = "SELECT * FROM product_master WHERE id = '$id'";  //取得した商品IDに基づいて、商品情報をセレクト
            $data = $connect->query($select);   //クエリ実行
            foreach($data as $value){
                $product_id = $value["id"];     //商品IDを取る
                $product_type_id = $value["product_type_id"];   //商品種別IDを取る
                $name = $value["name"];         //商品名を取る
                $price = $value["price"];       //価格を取る
                $shelf_life_days = $value["shelf_life_days"];   //賞味期限日数を取る
                $created_at = $value["created_at"];             //登録日を取る
                $updated_at = $value["updated_at"];             //更新日を取る
                $is_deleted = $value["is_deleted"];             //削除フラグを取る
            }
            //商品種別IDに基づいて、商品種別名をセレクト
            $selproduct_type_name = "SELECT name FROM product_type_master WHERE id = '$product_type_id'";
            $dataproduct_type_name = $connect->query($selproduct_type_name);    //クエリ実行
            foreach($dataproduct_type_name as $value){
                $product_type_name = $value["name"];            //商品種別名を取る
            }
        }
        $message = "";
        $updateMsg = "";
        if(!isset($_GET["checksubmit"])){                //更新動作確認
        }else{
            $productId = trim($_GET["productId"]);     //商品IDを取得
            $name = trim($_GET["name"]);               //商品名を取得
            $price = trim($_GET["price"]);             //価格を取得
            $shelf_life_days = trim($_GET["shelf_life_days"]);     //賞味期限日数を取得    
            if($name==""){                                          //商品名を未入力場合
                $message = "商品名を入力してください。";               //メッセージ設定
                goto outputMsg;
            }elseif($price=="" || $price <= 0){          //価格を未入力場合、又は<=0場合
                $message = "価格を入力してください。";      //メッセージ設定
                goto outputMsg;
            }elseif($shelf_life_days=="" || $shelf_life_days <= 0){  //賞味期限日数を未入力場合、又は<=0 場合
                $message = "賞味期限日数を入力してください。";          //メッセージ設定
                goto outputMsg;
            }else{
                $updated_at = date("Y-m-d H:i:s");                      //更新日を設定
                //取った値、取得した値、設定した値をアップデート          
                $update = "UPDATE product_master SET name='$name', price=$price, shelf_life_days=$shelf_life_days, updated_at='$updated_at' WHERE id='$productId'";
                $dataUpdate = $connect->query($update);                   //クエリ実行
                if($dataUpdate){                                          //クエリ実行確認
                    $updateMsg = "商品情報の更新が完了しました。";          //アップデート出来たメッセージ設定
                    goto outputMsg;
                }else{
                    $message = "商品情報の更新に失敗しました。";         //メッセージ設定
                    goto outputMsg;
                }
            }
        }
        outputMsg:                      //メッセージ出力
        echo "<h5>".$message."</h5>";
        if($updateMsg != ""){
            echo "<div class='modal_message'><div class='kakuninMsg'><div class='closeBtn'>✖</div><p>".$updateMsg."</p></div></div>";
        }  
    ?>
    <div class="modal_class1">
        <div class="kakuninMsg1">
            <div class="checkupdate">
                <h3><div id="checkvalue"></div>この商品情報を更新しますか？</h3>
            </div>
            <div class="closeBtn1">
                <button id="okBtn1">OK</button>
                <button id="cancelBtn">Cancel</button>
            </div>
        </div>
    </div>
    <div class="koshinclass">
        <div class="ichiran">
            <form id="updateform" name="updateform" action="editproduct_master.php" method="GET" onsubmit="return updateFunction()">
                <input id="checksubmit" value="">
                <input name="getUrl" type="hidden" value="<?php echo $getUrl; ?>"/>
                <input id="productId" name="productId" type="hidden" value="<?php echo $product_id ?>"/>
                <dl>
                    <dt>商品ID :</dt>
                    <dd><input name="id" disabled value="<?php echo $product_id; ?>"/></dd>                 
                </dl>
                <dl>
                    <dt>商品種別ID :</dt>
                    <dd><input name="product_type_id" disabled value="<?php echo $product_type_id; ?>"/></dd>
                </dl>
                <dl>
                    <dt>商品種別名 :</dt>
                    <dd><input name="product_type_name" disabled value="<?php echo $product_type_name; ?>"/></dd>
                </dl>
                <dl>
                    <dt>商品名 :</dt>
                    <dd><input name="name" value="<?php echo $name; ?>"/></dd>
                </dl>
                <dl>
                    <dt>単価 :</dt>
                    <dd><input id="price" name="price" type="number" value="<?php echo $price; ?>"/>円</dd>
                </dl>
                <dl>
                    <dt>賞味期限日数 :</dt>
                    <dd><input id="shelf_life_days" name="shelf_life_days" type="number" value="<?php echo $shelf_life_days; ?>"/>日</dd>
                </dl>
                <dl>
                    <dt>登録日 :</dt>
                    <dd><input name="created_at" disabled value="<?php echo $created_at; ?>"></dd>
                </dl>
                <dl>
                    <dt>更新日 :</dt>
                    <dd><input name="updated_at" disabled value="<?php echo $updated_at; ?>"></dd>
                </dl>
                <dl>
                    <dt>削除済 :</dt>
                    <dd><input id="is_deleted" name="is_deleted" type="checkbox" disabled ></dd>
                </dl>
                <input id="updateBtn" name="updateBtn" type="button" onClick="updateEvent()" value="更新">
            </form>
        </div>
        <div class="backBtn">
            <a href="product_master_detail.php?<?php echo $getUrl;?>">
                <input id="backBtn" name="backBtn" type="button" value="戻る">
            </a>
        </div>
    </div>
</body>
</html>
