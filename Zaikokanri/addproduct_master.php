<!DOCTYPE Html>
<html>
<head>
    <title>商品登録</title>
    <style>
        body{
            background-color:lightcyan;
        }
        h1{
            color:crimson;
        }
        h1,h2,h3,h5{
            text-align: center;
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
            margin: 20px;
            width: 300px;
            height: 35px;
            font-size: 20px;
        }
        label{
            color:mediumblue;
        }
        .product_master{
            width: 540px;
            margin:auto;
        }
        #shelf_life_days{
            margin-left: 20px;
        }
        #price{
            margin-left: 85px;
        }
        #name{
            margin-left: 70px;
            margin-top: 40px;
        }
        #id{
            margin-left: 67px;
        }
        #type{
            margin-left: 80px;
        }
        #product_type_name{
            margin-left: 31px;
        }
        #product_type_name, #type{
            width: 308px;
            height: 40px;
            font-size: 20px;
        }
        #product_type_id{
            margin-left: 30px;
            width: 154px;
        }
        select{
            margin-top: 10px;
        }
        #torokuBtn{
            margin-left: 115px;
            width: 100px;
            height:50px;
            border-radius: 2px;
            font-size: 20px;
            background-color:royalblue;
            color:white;
        }
        #backBtn{
            width: 100px;
            height:50px;
            border-radius: 2px;
            font-size: 20px;
            background-color:royalblue;
            color:white;
        }
        .backBtn{
            margin-left: 305px;
            margin-top: -90px;
        }
        .modal_message{
            width: 100%;
            height: 100%;
            position: fixed; /*位置を固定*/
            top:0;
            left:0;
            display: none;
            background-color: rgba(50, 50, 50, 0.7);
        }
        .error_message{
            border: 1px solid brown;
            position: absolute;
            width: 450px;
            height: 150px;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border-radius: 8px;
        }
        .modal_toroku{
            width: 100%;
            height: 100%;
            position: fixed; /*位置を固定*/
            top:0;
            left:0;
        }
        .toroku_message{
            border: 1px solid brown;
            position: absolute;
            width: 450px;
            height: 150px;
            top: 45%;
            left: 50%;
            margin-left: -5px;
            transform: translate(-50%, -50%);
            background-color: white;
            border-radius: 8px;
        }
        .closeBtn{
            float: right;
            margin-right: 10px;
            margin-top: 12px;
        }
        .close{
            float: right;
            cursor: pointer;
            margin-right: 10px;
        }
        #closeBtn{
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
    <script type="text/javascript" src="Js/addproduct_masters.js"></script>
</head>
<body>
    <h1>商品マスタ登録</h1>
    <hr width="55%">
    <?php
        //データに接続する
        include "dataConnect.php";
        //現在の商品種別名をセレクト、商品種別IDを取得するため
        $select = "SELECT name FROM product_type_master WHERE is_deleted = '0'";
        $data = $connect->query($select);   //クエリ実行
        $torokuMsg = "";
        $message = "";
        if(!isset($_POST["torokuBtn"])){                                //登録動作確認
            $product_type_id = "";       
        }else{
            $type = trim($_POST["type"]);
            $product_type_name = trim($_POST["product_type_name"]);           //商品種別名を取得
            $product_type_id_hidden = trim($_POST["product_type_id_hidden"]); //商品種別IDを取得(hiddenの値)
            if(isset($_POST["product_type_id"])){
                $product_type_id = trim($_POST["product_type_id"]);         //商品種別IDを取得
            }else{
                $product_type_id =  $product_type_id_hidden;
            }         
            $name = trim($_POST["name"]);                               //商品名を取得
            $price = trim($_POST["price"]);                             //価格を取得
            $shelf_life_days = trim($_POST["shelf_life_days"]);         //賞味期限日数を取得
            //入力した値を確認
            if($name==""){                         //商品名を未入力
                $message = "商品名を入力してください";
                goto outputMsg;
            }else{
                //存在する商品名をセレクト
                $selectName = "SELECT name FROM product_master WHERE is_deleted=0";
                $dataName = $connect->query($selectName);               //クエリ実行
                $row = array();                     //商品名の配列宣言
                foreach($dataName as $value){
                    $row[] = $value["name"];        //商品名を取る
                }
                if(in_array($name, $row, true)==true){  //入力した商品名の存在を確認
                    $message = "商品名が存在しました。";  
                    goto outputMsg;
                }
            }          
            if($price<=0 || $price==""){           //価格<=0 OR 未入力
                $message = "価格を入力してください";
                goto outputMsg;
            }elseif($shelf_life_days<= 0 || $shelf_life_days ==""){     //賞味期限日数<= 0 OR 未入力
                $message = "賞味期限日数を入力してください";
                goto outputMsg;
            }
            else{
                //存在する種別IDをセレクト
                $selectProduct_type_id = "SELECT product_type_id FROM product_master WHERE product_type_id='$product_type_id'";
                $dataProduct_type_id = $connect->query($selectProduct_type_id); //クエリ実行
                $count = mysqli_num_rows($dataProduct_type_id);                 //種別IDの数を確認
                $count += 1;                                                    //商品Noを設定              
                $subId = $product_type_id.str_pad($count,'4',0,STR_PAD_LEFT);   //商品IDを設定
                $is_deleted = 0;                         //フラッグを設定
                $created_at = date("Y-m-d H:i:s");       //登録を設定
                $updated_at = date("Y-m-d H:i:s");       //更新日を設定
                //取得した値と設定した値をインサート
                $insert = "INSERT INTO product_master (id, name, product_type_id, price, shelf_life_days, is_deleted, created_at, updated_at) 
                            VALUES ('$subId', '$name', '$product_type_id', $price,  $shelf_life_days, $is_deleted, '$created_at', '$updated_at')";
                if($connect->query($insert)){                 //クエリ実行確認
                    $torokuMsg = "商品登録が完了しました。";    //登録メッセージを設定
                    //入力した情報を空にする
                    $type = "";
                    $product_type_name = "";
                    $product_type_id = "";
                    $product_type_id_hidden = "";
                    $name = "";
                    $price = "";
                    $shelf_life_days = "";
                    goto outputMsg;
                }else{
                    $message = "商品登録失敗しました。";    //登録失敗メッセージを設定
                    goto outputMsg;
                }
            }
        }
        outputMsg:              //メッセージ出力
        echo "<h5 id='idh5'>".$message."</h5>";
        if($torokuMsg != ""){
            echo "<div class='modal_toroku'><div class='toroku_message'><div class='close'>✖</div><p>".$torokuMsg."</p></div></div>";
        }   
    ?>
    <div class="modal_message">
        <div class="error_message">
            <div id="type_class">
                <h3>種別を選択してください。</h3><br>
            </div>
            <div id="product_type_class1">
                <h3>商品種別名を選択してください。</h3><br>
            </div>
            <div id="product_type_class2">
                <h3>商品種別名が存在しない為、<br>先に商品種別名を登録してください。</h3>
            </div>
            <div class="closeBtn">
                <button id="closeBtn">OK</button>
            </div>
        </div>
    </div>
    <div class="product_master">
        <form name="torokuform" action="addproduct_master.php" method="POST" onsubmit="return torokuFunction()">
            <label>種別
                <select id="type" name="type">
                    <option value="">種別を選択してください</option>
                    <?php
                        //大項目の種別名をセレクト
                        $selectType = "SELECT name FROM product_type_master WHERE type_number=1 AND is_deleted=0";
                        $dataType = $connect->query($selectType);               //クエリ実行
                        foreach($dataType as $value){
                            $nameType = $value["name"];                         //種別名を取る
                            if($type==$nameType){
                                echo "<option selected>".$nameType."</option>";
                            }else{
                                echo "<option>".$nameType."</option>";
                            }
                        }
                    ?>
                </select>
            </label></br>
            <label>商品種別名
                <select id="product_type_name" name="product_type_name">
                    <?php
                        if($product_type_name!=""){
                            echo "<option selected>".$product_type_name."</option>";
                        }else{
                            "<option>".$product_type_name."</option>";
                        }
                    ?>
                </select>
            </label><br>
            <label>商品種別ID
                <input id="product_type_id_hidden" type="hidden" name="product_type_id_hidden" value="<?php if(!empty($product_type_id_hidden)){echo $product_type_id_hidden;} ?>">
                <input id="product_type_id" name="product_type_id" disabled value = "<?php if(!empty($product_type_id_hidden)){echo $product_type_id_hidden;}else{echo "";} ?>"/> 
            </label><br>
            <?php echo "<hr width='85%' color='oliver'>" ?>
            <label>商品名<input id="name" name="name" value="<?php if(isset($name)){echo $name;} ?>" /></label><br>
            <label>価格<input id="price" name="price" type="number" min="0" max="1000000" value="<?php if(isset($price)){echo $price;} ?>"/></label><br>
            <label>賞味期限日数<input id="shelf_life_days" name="shelf_life_days" type="number" min="0" max="1000000" value="<?php if(isset($shelf_life_days)){echo $shelf_life_days;} ?>"/></label><br>
            <input id="torokuBtn" name="torokuBtn" type="submit" value="登録"/>
        </form>
        <div class="backBtn">
            <form action="product_master_kanri.php" method="POST">
                <input id="backBtn" name="backBtn" type="submit" value="戻る"/>
            </form>
        </div>
    </div>
</body>
</html>
