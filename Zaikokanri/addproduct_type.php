<!DOCTYPE Html>
<html>
<head>
    <title>商品種別登録</title>
    <style>
        body{
            background-color:lightcyan;
        }
        h1{
            color:crimson;
        }
        h1,h2,h3,h5{
            text-align:center;
        }
        h2{
            margin-left: 10px;
            color:navy;
        }
        h3{
            color:purple;
        }
        h5{
            color:red;
        }
        input,select{
            margin: 20px;
            width: 300px;
            height: 40px;
            font-size: 20px;
        }
        label{
            color:mediumblue;
        }
        #typeId{
            margin-left: 80px;
        }
        #product_type_id{
            width: 100px;
            margin-left:28px;
        }
        #numberId{
            width: 150px;
        }
        #name{
            margin-left: 35px;
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
        .productype_class{
            width: 550px;
            margin: auto;
        }
        .backBtn{
            margin-left: 305px;
            margin-top:-90px;
        }
        .hiddenclass{
            display: none;
        }
        .modal_class{
            background-color: rgba(50, 50, 50, 0.7);
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            display: none;
        }
        .kakuninMsg{
            border: 1px solid brown;
            position: absolute;
            width: 450px;
            height: 150px;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border-radius: 6px;
        }
        #okBtn{
            width: 70px;
            height: 35px;
            border-radius: 6px;
            float: right;
            margin-top: 12px;
            margin-right: 10px;
            background-color:royalblue;
            color:white;
        }
        .modal_toroku{
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }
        .torokuMsg{
            border: 1px solid brown;
            position: absolute;
            width: 400px;
            height: 120px;
            top: 20%;
            left: 50%;
            margin-left: -20px;
            transform: translate(-50%, -50%);
            background-color: white;
            border-radius: 6px;
        }
        .closeBtn{
            float:right;
            margin-right: 5px;
            cursor: pointer;
        }
        p{
            color: navy;
            text-align: center;
            font-size: 20px;
        }
        .product_type_id_hidden{
            display: none;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="Js/addproduct_type.js"></script>
</head>
<body>
    <h1>商品種別マスタ登録</h1>
    <hr width="60%">
    <?php
        //データに接続する
        include "dataConnect.php";
        $message = "";
        $torokuMsg = "";
        if(!isset($_POST["torokuBtn"])){                            //登録動作確認
        }else{
            $typeId = trim($_POST["typeId"]);                                     //セレクトした種別を取得       
            if($typeId == ""){
                $product_type_id = trim($_POST["product_type_id"]);
            }else{
                $product_type_id = trim($_POST["product_type_id_hidden"]);     //セレクトした商品種別IDを取得(hiddenの値)
            }
            $numberId = trim($_POST["numberId_hidden"]);    //セレクトした商品種別IDを取得(hiddenの値)
            $name = trim($_POST["name"]);                           //商品種別名を取得
            //存在する商品種別名をセレクト
            $selectName = "SELECT name FROM product_type_master WHERE is_deleted=0";
            $dataName = $connect->query($selectName);               //クエリ実行
            $rowName = array();                                     //商品種別名の連想配列を宣言
            foreach($dataName as $value){
                $rowName[] = $value["name"];                        //配列の要素を取る
            }
            if($name==""){                                          //商品種別名を未入力場合
                $message = "商品種別名を入力してください。";           //エラーメッセージ設定
                goto outputMsg;
            }elseif(in_array($name, $rowName, true)==true){         //入力した商品種別名の存在を確認
                $message = "商品種別名が存在しました。";               //エラーメッセージ設定
                goto outputMsg;
            }else{
                //存在した種別IDをセレクト
                $selectId = "SELECT id FROM product_type_master WHERE id LIKE '%$product_type_id%'";
                $dataId = $connect->query($selectId);               //クエリ実行
                $count = mysqli_num_rows($dataId);                  //商品種別IDの数を確認
                $count += 1;                                        //種別Noを設定
                $id = $product_type_id.$numberId;                   //種別IDを設定
                $is_delete = 0;                                     //商品種別状態を設定
                $created_at = date("Y-m-d H:i:s");                  //登録日を設定
                $updateted_at = date("Y-m-d H:i:s");                //更新日を設定
                //商品種別情報の入力した値と設定した値をインサート
                $insert = "INSERT INTO product_type_master (id, type_id, type_number, name, is_deleted, created_at, updated_at) 
                            VALUES ('$id', '$product_type_id', $count, '$name', $is_delete, '$created_at', '$updateted_at')";
                if($connect->query($insert)){                       //クエリ実行確認
                    $torokuMsg = "商品種別登録が完了しました。";           //登録状態メッセージ設定
                    //入力した値を空にする
                    $typeId = "";
                    $product_type_id_hidden = "";
                    $product_type_id = "";
                    $numberId_hidden = "";
                    $numberId = "";
                    $name = "";
                    goto outputMsg;
                }else{
                    $message = "商品種別登録に失敗しました。";            //登録状態メッセージ設定
                    goto outputMsg;
                }
            }
        }
        outputMsg:
        echo "<h5 id='idh5'>$message</h5>";
        if($torokuMsg!=""){
            echo "<div class='modal_toroku'><div class='torokuMsg'><div class='closeBtn'>✖</div><p>".$torokuMsg."</p></div></div>";
        }     
    ?>
    <div class="modal_class">
        <div class="kakuninMsg">
            <div class="typeIdClass">
                <h3>商品種別IDを選択してください。</h3><br>
                <button id="okBtn">OK</button>
            </div>
        </div>
    </div>
    <div class="productype_class"> 
        <form name="torokuform" action="addproduct_type.php" method="POST" onsubmit="return torokuFunction()">   
            <label>種別
                <select id="typeId" name="typeId">
                    <option value="">新規登録</option>
                    <?php
                        //存在する商品種別名をセレクト
                        $selectType = "SELECT name FROM product_type_master WHERE type_number=1";
                        $dataType = $connect->query($selectType);           //クエリ実行
                        foreach($dataType as $value){
                            $tpName = $value["name"];                       //商品種別名を取る
                            if($typeId==$tpName){
                                echo "<option selected>".$tpName."</option>";
                            }else{
                                echo "<option>".$tpName."</option>";
                            }
                        }
                    ?>
                </select>
            </label>
            <?php echo "<hr width='85%' color='oliver'>" ?>
            <label>商品種別ID
                <div class="product_type_id_hidden">
                    <select id="product_type_id_hidden" name="product_type_id_hidden" value="<?php if(!empty($product_type_id)){echo $product_type_id;}?>">
                        <?php
                            if($product_type_id != ""){
                                echo "<option selected>".$product_type_id."</option>";
                            }
                        ?>
                    </select>
                </div>           
                <select id="product_type_id" name="product_type_id" <?php if($typeId!=""){echo "disabled";} ?> value="<?php if(!empty($product_type_id)){echo $product_type_id;} ?>">
                    <?php              
                        if($typeId!=""){
                            echo "<option selected>".$product_type_id."</option>";
                        }else{
                            echo "<option></option>";
                            //アスファルト設定ファイルに接続する
                            include "zalphabet.php";
                            //存在する種別IDをセレクト
                            $selectType_id = "SELECT type_id FROM product_type_master WHERE type_number=1 AND is_deleted=0";
                            $dataType_id = $connect->query($selectType_id);     //クエリ実行
                            $row = array();                                     //種別IDの配列宣言
                            foreach($dataType_id as $value){
                                $row[] = $value["type_id"];                     //種別IDを配列に入れる
                            }
                            $result = array_diff($alphabet_array, $row);        //存在した種別ID以外を取る                   
                            foreach($result as $key){
                                if($product_type_id==$key){
                                    echo "<option selected>".$key."</option>";
                                }else{
                                    echo "<option>".$key."</option>";
                                }
                            }                      
                        }
                    ?>           
                </select>
            </label>
            <input id="numberId_hidden" name="numberId_hidden" type="hidden" value="<?php if(isset($numberId)){echo $numberId;}?>"/>
            <input id="numberId" name="numberId" disabled value="<?php if(isset($numberId)){echo $numberId;}?>"/></br>                     
            <label>商品種別名<input id="name" name="name" value="<?php if(isset($name)){echo $name;}?>"/></label><br>
            <input id = "torokuBtn" name="torokuBtn" type="submit" value="登録">
        </form>

        <div class="backBtn">
            <form action="product_type_kanri.php" method="GET">
                <input id="backBtn" name="backBtn" type="submit" value="戻る">
            </form>
        </div>
    </div>
</body>
</html>
