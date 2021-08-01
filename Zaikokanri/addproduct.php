<!DOCTYPE Html>
<html>
<head>
    <title>在庫登録</title>
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
            color:red;
        }
        input{
            margin: 20px;
            width: 250px;
            height: 30px;
            font-size: 20px;
        }
        select{
            margin: 20px;
            width: 255px;
            height: 35px;
            font-size: 20px;
        }
        form dl dt{
            width: 100px;
            float: left;
            margin-top: 20px;
            color:mediumblue;
        }
        .torokuclass{
            width: 500px;
            margin:auto;
        }
        #backBtn,#torokuBtn{
            width: 100px;
            height: 50px;
            border-radius: 2px;
            font-size: 20px;
            background-color:royalblue;
            color:white;
        }
        #torokuBtn{
            margin-left: 120px;
        }
        .backBtn{
            margin-left: 255px;
            margin-top: -90px;
        }
        .typeclass,.product_typeclass{
            margin: 2px;
            margin-left: 20px;
        }
        .modal,.modal-message{
            width: 100%;
            height: 100%;
            position: fixed;
            top:0;
            left:0;
            background-color: rgba(50, 50, 50, 0.7);
        }
        .modal-message{
            display: none;
        }        
        .torokuMsg{
            border: 1px solid brown;
            position: absolute;
            width: 350px;
            height: 80px;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -10%);
            background-color: white;
            border-radius: 6px;
        }
        .kakuninMsg{
            border: 1px solid brown;
            position: absolute;
            width: 450px;
            height: 150px;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border-radius: 8px;
        }
        .close{
            float: right;
            margin-right: 5px;
            font-size: 20px;
            cursor: pointer;
        }
        .closeBtn{
            float: right;
            margin-right: 10px;
            margin-top:12px;
        }
        #kakukinBtn{
            width: 70px;
            height: 35px;
            border-radius: 6px;
            background-color:royalblue;
            color:white;
        }
        p{
            color: navy;
            text-align: center;
            font-size: 20px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="Js/addproducts.js"></script>
</head>
<body>
    <h1>在庫登録</h1>
    <hr width="50%">
    <?php
        //データに接続する
        include "dataConnect.php";
        $message = "";
        $torokuMsg = "";
        if(!isset($_POST["torokuBtn"])){                        //在庫登録動作確認
        }else{
            $type = trim($_POST["type"]);                       //種別を取得
            $product_type = trim($_POST["product_type"]);       //商品種別名を取得 
            $product_name = trim($_POST["product_name"]);       //商品名を取得
            $stock_quantity = trim($_POST["stock_quantity"]);   //個数を取得
            $arrival_date = trim($_POST["arrival_date"]);       //入荷日を取得
            //種別IDをセレクト
            $selectType_id = "SELECT type_id FROM product_type_master WHERE name='$type' AND is_deleted=0";
            $dataType_id = $connect->query($selectType_id);     //クエリ実行
            $result = mysqli_fetch_array($dataType_id);         //データの連想配列を取得
            $type_id = $result["type_id"];                      //種別IDを取る(アルファベット1文字)
            if($stock_quantity=="" || $stock_quantity<=0){      //個数を未入力場合、又は入力した値は<=0場合
                $message = "個数を入力してください。";            //メッセージ設定
                goto outputMsg;
            }elseif($arrival_date==""){                         //入荷日を未入力場合
                $message = "入荷日を選択してください。";          //メッセージ設定
                goto outputMsg;
            }else{            
                $date = date("Ymd");    //現時点を設定
                $subProduc_id = substr($date,2,2).substr($date,4,2).substr($date,6,2).$type_id;            //在庫IDの基本を設定
                $selectCount = "SELECT id FROM stock WHERE id like '%$subProduc_id%'";                      //存在する在庫IDの同じ種類をセレクト
                $dataselectCount = $connect->query($selectCount);                       //クエリ実行
                $count = mysqli_num_rows($dataselectCount);                             //存在する在庫IDの同じ種類の数を取る
                $count += 1;
                $id = $subProduc_id.str_pad($count,3,0,STR_PAD_LEFT);                   //在庫IDの全体を設定     
                //賞味期限の計算
                $selectShelf_life_days = "SELECT id,shelf_life_days FROM product_master WHERE name='$product_name'";    //賞味期限日数をセレクト
                $dataselectShelf_life_days = $connect->query($selectShelf_life_days);   //クエリ実行
                foreach($dataselectShelf_life_days as $value){
                    $product_id = $value["id"];                                         //商品IDを取る
                    $shelf_life_days = $value["shelf_life_days"];                       //賞味期限日数を取る
                }
                $shelf_life_date = date("Y-m-d H:i:s", strtotime("+$shelf_life_days day".$arrival_date));         //賞味期限を設定
                $is_deleted = 0;                    //削除フラッグ設定(デフォルト:0)
                $created_at = date("Y-m-d H:i:m");  //登録日を設定
                $updated_at = date("Y-m-d H:i:m");  //更新日を設定(デフォルト:登録日と同じようにする)
                //取得した値、設定した値をインサート
                $insert = "INSERT INTO stock (id, product_id, stock_quantity, arrival_date, shelf_life_date, is_deleted, created_at, updated_at) 
                            VALUES ('$id', '$product_id', $stock_quantity, '$arrival_date', '$shelf_life_date', $is_deleted, '$created_at', '$updated_at')";
                $data = $connect->query($insert);          //クエリ実行
                if(!empty($data)){                         //クエリ実行確認
                    $torokuMsg = "在庫登録が完了しました。";     //登録出来たメッセージ設定
                    //入力した情報を空にする
                    $type = "";
                    $product_type = "";
                    $product_name = "";
                    $stock_quantity = "";
                    $arrival_date = "";
                    goto outputMsg;
                }else{
                    $message = "在庫登録に失敗しました。";      //登録失敗したメッセージ設定
                    goto outputMsg;
                }
            }
        }
        outputMsg:                  //メッセージ出力
        echo "<h5 id='idh5'>".$message."</h5>";
        if($torokuMsg!=""){
            echo "<div class='modal'><div class='torokuMsg'><div class='close'>✖</div><p>".$torokuMsg."</p></div></div>";
        }    
    ?>
    <div class="modal-message">
        <div class="kakuninMsg">
            <div id="type_class1">
                <h3>種別を選択してください。</h3><br>
            </div>
            <div id="type_class2">
                <h3>商品種別名が存在しない為、<br>先に商品種別名を登録してください。</h3>
            </div>
            <div id="product_type_class1">
                <h3>商品種別名または、<br>商品名を選択してください。</h3>
            </div>
            <div id="product_type_class2">
                <h3>商品名が存在しない為、<br>先に商品名を登録してください。</h3>
            </div>
            <div class="closeBtn">
                <button id="kakukinBtn">OK</button>
            </div>
        </div>
    </div>
    <div class="torokuclass">
        <form name="torokuform" action="addproduct.php" method="POST" onsubmit="return torokuFunction()">
            <dl>
                <dt>種別：</td>
                <dd>
                    <select  class="typeclass" id="type" name="type">
                        <option></option>
                        <?php
                            //種別名の大項目をセレクト
                            $selectType = "SELECT type_id,name FROM product_type_master WHERE type_number = 1 AND is_deleted=0";
                            $dataType = $connect->query($selectType);       //クエリ実行
                            foreach($dataType as $value){
                                $name = $value["name"];                     //種別名を取る
                                if($type==$name){
                                    echo "<option selected>".$name."</option>";
                                }else{
                                    echo "<option>".$name."</option>";
                                }
                            }
                        ?>
                    </select> 
                </dd>
            </dl>
            <dl>
                <dt>商品種別名：</td>
                <dd>
                    <select  class="product_typeclass" id="product_type" name="product_type">
                        <?php 
                            if($product_type!=""){
                                echo "<option selected>".$product_type."</option>";
                            }else{
                                echo "<option></option>";
                            }
                        ?>
                    </select>
                </dd>
            </dl>
            <?php echo "<hr width='90%' color='oliver'>" ?>
            <dl>
                <dt>商品名：</dt>
                <dd>
                    <select id="product_name" name="product_name" >
                        <?php
                            if($product_name!=""){
                                echo "<option selected>".$product_name."</option>";
                            }else{
                                echo "<option>".$product_name."</option>";
                            } 
                        ?>        
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>個数:</dt>
                <dd><input name="stock_quantity" type="number" min="0" max="1000000" value="<?php if(isset($stock_quantity)){echo $stock_quantity;}?>"/></dd>
            </dl>
            <dl>
                <dt>入荷日：</dt>
                <dd><input name="arrival_date" type="datetime-local" value="<?php if(isset($arrival_date)){echo $arrival_date;}?>"/></dd>
            </dl>
            <input id="torokuBtn" name="torokuBtn" type="submit" value="登録">
        </form>
        <div class="backBtn">
            <form action="stock.php" method="POST">
                <input id="backBtn" name="backBtn" type="submit" value="戻る">
            </form>
        </div>
    </div>
</body>
</html>
