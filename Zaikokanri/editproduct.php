<!DOCTYPE Html>
<html>
<head>
    <title>在庫更新</title>
    <style>
        body{
            background-color:lightcyan;
        }
        h1,h3,h4,h5,p{
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
            font-size:20px;
        }
        form dl dt{
            width:100px;
            float:left;
            margin-top: 15px;
            margin-right:5px;
            color:mediumblue;
        }
        #is_deleted{
            margin-left: -130px;
        }
        .koshinclass{
            width: 450px;
            margin:auto;
        }
        .backBtn{
            margin-top: -76px;
            margin-left: 310px;
        }
        #koshinBtn,#backBtn{
            width: 100px;
            height: 50px;
            border-radius: 2px;
            font-size: 20px;
            background-color:royalblue;
            color:white;
        }
        #closeBtn{
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
            background-color: rgba(50, 50, 50, 0.7);
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            display: none;
        }
        .modal_class2{
            background-color: rgba(50, 50, 50, 0.7);
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }
        .kakuninMsg1{
            border: 1px solid brown;
            position: absolute;
            width: 450px;
            height: 180px;
            top: 40%;
            left: 50%;
            margin-left: 35px;
            transform: translate(-50%,-50%);
            background-color: white;
            border-radius: 6px;
        }
        .kakuninMsg2{
            border: 1px solid brown;
            position: absolute;
            width: 400px;
            height: 120px;
            top: 30%;
            left: 50%;
            margin-left: 35px;
            transform: translate(-50%,-50%);
            background-color: white;
            border-radius: 6px;
        }
        #okBtn,#cancelBtn{
            width: 70px;
            height: 35px;
            border-radius: 6px;
            background-color:royalblue;
            color:white;
            margin-left: 50px;
        }
        #cancelBtn{
            width: 90px;
        }
        .closeBtn{
            width: 300px;
            margin: auto;
        }
        .exitBtn{
            float: right;
            margin-right: 5px;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function updateEvent(){
            var stock_quantity = document.getElementById("stock_quantity").value;
            var valueid = document.getElementById("valueid").value;
            if(stock_quantity==""){
                return false;
            }else{
                document.getElementById("updatevalue").innerHTML = "在庫ID("+valueid+")、";
                $('.modal_class1').fadeIn(0.001);
            } 
        }
        $(document).on('click','#okBtn',function(){
            document.getElementById("formupdate").submit();
            $('#checksubmit').val(); 
            $('.closeBtn').fadeOut(0.0001);      
        });
        $(document).on('click','#cancelBtn',function(){
            $('.modal_class1').fadeOut(0.0001);  
        });
        $(document).on('click','#exitBtn',function(){
            $('.modal_class2').fadeOut(0.0001);  
        });     
    </script>
</head>
<body>
    <h1>在庫更新</h1>
    <hr width="50%">
    <?php
        //データに接続する
        include "dataConnect.php"; 
        if(!isset($_GET["valueid"])){                                   //在庫一覧表示画面からの在庫IDの取得を確認
        }else{
            $id = trim($_GET["valueid"]);                          //在庫IDを取得
            $getUrl = $_GET["getUrl"];                             //在庫検索結果のURLを取得
            $selectStock = "SELECT * FROM stock WHERE id='$id'";    //在庫情報をセレクト      
            $dataStock = $connect->query($selectStock);             //クエリ実行
            foreach($dataStock as $value){
                $product_id = $value["product_id"];                 //商品IDを取る
                $stock_quantity = $value["stock_quantity"];         //個数を取る
                $arrival_date = $value["arrival_date"];             //入荷日を取る
                $days = date("Y-m-d",strtotime($arrival_date));     //年、月、日の部分を区別
                $time = date("H:i",strtotime($arrival_date));       //時、分の部分を区別
                $shelf_life_date = $value["shelf_life_date"];       //賞味期限を取る
                $is_deleted = $value["is_deleted"];                 //削除フラッグを取る
                $created_at = $value["created_at"];                 //登録日を取る
                $updated_at = $value["updated_at"];                 //更新日を取る
            }           
            //商品IDに基づいて、商品情報をセレクト
            $selectProduct_master = "SELECT name, product_type_id, price, shelf_life_days FROM product_master WHERE id='$product_id'";
            $dataProduct_master = $connect->query($selectProduct_master);   //クエリ実行
            foreach($dataProduct_master as $key){                           
                $name = $key["name"];                                       //商品名を取る
                $product_type_id = $key["product_type_id"];                 //種別IDを取る
                $price = $key["price"];                                     //単価を取る
                $shelf_life_days = $key["shelf_life_days"];                 //賞味期限日数を取る              
            }
            //種別IDに基づいて、種別名をセレクト
            $selectProduct_type_master = "SELECT name FROM product_type_master WHERE id='$product_type_id'";
            $dataProduct_type_master = $connect->query($selectProduct_type_master);     //クエリ実行
            $result = mysqli_fetch_array($dataProduct_type_master);                     //データの連想配列を取得
            $product_type_name = $result["name"];                                       //種別名を取る
        }
        $message = "";
        $updateMsg = "";
        if(!isset($_GET["checksubmit"])){                            //更新動作確認
        }else{
            echo $_GET["checksubmit"];
            $stockid = trim($_GET["valueid"]);                     //在庫IDを取得
            $stock_quantity = trim($_GET["stock_quantity"]);       //個数を取得
            $arrival_date = trim($_GET["arrival_date"]);           //入荷日を取得
            if($stock_quantity<=0 || $stock_quantity==""){         //入力した個数の値を確認
                $message = "単価を入力してください";                 //エラーメッセージ設定        
                goto outputMsg;
            }elseif($arrival_date==""){                            //入力した入荷日を確認   
                $message = "入荷日を選択してください";               //エラーメッセージ設定           
                goto outputMsg;
            }else{
                //賞味期限の計算
                $shelf_life_date = date("Y-m-d H:i:s",strtotime("+$shelf_life_days day".$arrival_date));
                $date_day = date("Y-m-d H:i",strtotime($arrival_date));  //取得した入荷日を設定
                $days = date("Y-m-d",strtotime($date_day));              //年、月、日の部分を区別
                $time = date("H:i",strtotime($date_day));                //時、分の部分を区別
                $updated_at = date("Y-m-d H:i:s");                       //更新日を設定
                //在庫の情報をアップデート
                $update = "UPDATE stock SET stock_quantity=$stock_quantity, arrival_date='$arrival_date', 
                            shelf_life_date='$shelf_life_date', updated_at='$updated_at' WHERE id='$stockid'";
                $dataupdate = $connect->query($update);                  //クエリ実行
                if($dataupdate){
                     $updateMsg = "在庫更新が完了しました。";               //更新メッセージ設定
                     goto outputMsg;
                }else{ 
                    $message = "在庫更新に失敗しました";                   //更新のエラーメッセージ設定
                    goto outputMsg;
                }
            }
        }                           
        outputMsg:
        echo "<h5>".$message."</h5>";
        if($updateMsg != ""){
            echo "<div class='modal_class2'>
                    <div class='kakuninMsg2'>
                        <div class='exitBtn' id='exitBtn'>✖</div>
                        <p>在庫更新が完了しました。</p>               
                    </div>
                </div>";
        }  
    ?>
    <div class="modal_class1">
        <div class="kakuninMsg1">
            <div class="checkupdate">
                <h3><div id="updatevalue"></div>この在庫の情報を更新しますか？</h3><br>
            </div>
            <div class="closeBtn">
                <input id="okBtn" name="okBtn" type="button" value="OK" />
                <button id="cancelBtn">キャンセル</button>
            </div>
        </div>
  </div>
    <div class="koshinclass">
        <div>
            <form id="formupdate" name="formupdate" action="editproduct.php" method="GET" >
                    <input id="checksubmit" type="hidden" name="checksubmit" value=""/>
                    <input id="valueid" name="valueid" type="hidden" value="<?php echo $id;?>"/>
                    <input name="getUrl" type="hidden" value="<?php echo $getUrl;?>"/>
                <dl>
                    <dt>在庫ID：</dt>
                    <dd><input name="id" disabled value="<?php echo $id; ?>"></dd>
                </dl>
                <dl>
                    <dt>種別ID：</dt>
                    <dd><input name="product_type_id" disabled value="<?php echo $product_type_id;?>"/></dd>
                </dl>
                <dl>
                    <dt>種別名：</dt>
                    <dd><input name="product_type_name" disabled value="<?php echo $product_type_name;?>"/></dd>
                </dl>
                <dl>
                    <dt>商品ID：</dt>
                    <dd><input name="product_id" disabled value="<?php echo $product_id;?>"/></dd>
                </dl>
                <dl>
                    <dt>商品名：</dt>
                    <dd><input name="name" disabled value="<?php echo $name;?>"/></dd>
                </dl>
                <dl>    
                    <dt>単価：</dt>
                    <dd><input name="price" disabled value="<?php echo $price;?>"/>円</dd>
                </dl>
                <dl>    
                    <dt>個数：</dt>
                    <dd><input id="stock_quantity" name="stock_quantity" type="number" min="0" max="10000"value="<?php echo $stock_quantity;?>"/></dd>
                </dl>
                <dl>
                    <dt>入荷日：</dt>
                    <dd><input id="arrival_date" name="arrival_date" type="datetime-local" value="<?php echo $days."T".$time; ?>"/></dd>
                </dl>
                <dl>
                    <dt>賞味期限：</dt>
                    <dd><input name="shelf_life_date" type="datetime" disabled value="<?php echo $shelf_life_date;?>"/></dd>
                </dl>
                <dl>
                    <dt>登録日：</dt>
                    <dd><input name="created_at" type="datetime" disabled value="<?php echo $created_at;?>"/></dd>
                </dl>
                <dl>
                    <dt>更新日：</dt>
                    <dd><input name="updated_at" type="datetime" disabled value="<?php echo $updated_at;?>"/></dd>
                </dl>
                <dl>
                    <dt>削除済：</dt>
                    <dd><input id="is_deleted" name="is_deleted" disabled type="checkbox"/></dd>
                </dl>
                <dl>
                    <dt></dt>
                    <dd><input id="koshinBtn" name="updateBtn" type="button"  onClick="updateEvent()" value="更新"></dd>
                </dl>
            </form>
        </div>
        <div class="backBtn">
            <a href="product_detail.php?<?php echo $getUrl;?>">
                <input id="backBtn" name="backBtn" type="button" value="戻る"/>
            </a>
        </div>
    </div>
</body>
</html>
