<!DOCTYPE Html>
<html>
<head>
    <title>商品一覧</title>
    <style>
        body{
            background-color:lightcyan;
        }
        h1,h3,h5{
            text-align: center;
        }
        h1{
            color:crimson;
        }
        h3{
            color:purple;
        }
        h5{
            color: red;
        }
        .product_master_detail{
            width: 650px;
            margin:auto;
        }
        #id,#product_type_id, .product_type_name,#name{
            margin: 20px auto;
            width: 150px;
            height: 25px;
            font-size: 15px;
        }
        label{
            margin-left: 20px;
            color:mediumblue;
        }
        .product_type_name{
            margin: 20px auto;
            width: 155px;
            height: 30px;
            font-size: 15px;
        }
        #kensakuBtn{
            width: 90px;
            height: 50px;
            border-radius: 2px;
            font-size: 20px;
        }
        #id{
            margin-left: 70px;
        }
        #product_type_id{
            margin-left: 10px;
        }
        .product_type_name{
            margin-left: 36px;
        }
        #name{
            margin-left: 50px;
        }
        #is_deleted{
            margin-left: 10px;
        }
        #kensakuBtn{
            margin-top:20px;
            margin-left: 140px;
            background-color:royalblue;
            color:white;
        }
        .backBtn{
            width: 650px;
            margin-left: 480px;
            margin-top: -95px;
        }
        #backBtn{
            width: 100px;
            height: 50px;
            border-radius: 2px;
            font-size: 20px;
            margin-top: 45px;
            background-color:royalblue;
            color:white; 
        }
        table,tr,th,td{
            border: 1px solid black;
        }
        th{
            color:blue;
        }
        table{
            margin: auto;
            background-color:white;
        }
        .table_class{
            min-width: 1100px;
            margin-top: 50px;    
        }
        #table{
            margin-bottom: 50px;
        }
        #shosaiBtn,#koshinBtn,#deleteBtn{
            width: 100px;
            height: 50px;
            border-radius: 2px;
            font-size: 20px;
            background-color:royalblue;
            color:white;
        }
        #koshinBtn,#deleteBtn{
            margin-left: 5px;
        }
        .classBtn{
            display: flex;
            margin-top: 20px;
            margin-left: 140px;
        }
        .selected{
            background-color:aquamarine;
            color:firebrick;
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
            height: 180px;
            top: 40%;
            left: 50%;
            margin-left: 32px;
            transform: translate(-50%,-50%);
            background-color: white;
            border-radius: 6px;
        }
        .closeBtn{
            float: right;
            margin-right: 10px;
            font-size: 20px;
            cursor: pointer;
            margin-top: 12px;
        }
        #okBtn,#kakuninBtn,#cancelBtn{
            width: 70px;
            height: 35px;
            border-radius: 6px;
            background-color:royalblue;
            color:white;
        }
        #cancelBtn{
            width: 90px;
            margin-right: 100px;
            background-color:royalblue;
        }
        .checkBtn{
            width: 250px;
            margin: auto;
        }
        .checkdelete{
            display: inline;
        }
        .cancelBtn{
            float: right;
            margin-top: -35px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#table tr:not(:first)").on('click',function(){
                var row_value = $(this).closest("tr");
                var product_id = row_value.find("td:eq(0)").html();
                var is_deleted = row_value.find("td:eq(7)").html();
                var checked = $(this).hasClass("selected");
                $("#table tr").removeClass("selected");
                if(!checked){
                    $(this).addClass("selected");
                    document.forms["shosaiform"]["productId"].value = product_id;
                    document.forms["shosaiform"]["is_deleted"].value = is_deleted;
                    document.forms["koshinform"]["productId"].value = product_id;
                    document.forms["deleteform"]["productId"].value = product_id;
                }else{
                    document.forms["shosaiform"]["productId"].value = "";
                    document.forms["shosaiform"]["is_deleted"].value = "";
                    document.forms["koshinform"]["productId"].value = "";
                    document.forms["deleteform"]["productId"].value = "";
                }
            });
            $(".closeBtn").on('click',function(){
                $(".modal_class").fadeOut(0.0001);        
            });        
            $('#shosaiBtn, #koshinBtn, #deleteBtn').on('click',function(){
                var countData = document.getElementById("countData").value;
                var product_id = document.forms["koshinform"]["productId"].value;
                if(countData==0){
                    //alert("データが存在しません。");
                    $(".modal_class").fadeIn(0.001);
                    $(".checkdata").fadeIn(0.001);
                    $(".closeBtn").fadeIn(0.001);
                    $(".checktr").fadeOut(0.0001);
                    $(".checkupdate").fadeOut(0.0001);
                    $(".checkdelete").fadeOut(0.0001);  
                    return false;
                }else if(product_id==""){
                    //alert("商品情報を選択してください。");
                    $(".modal_class").fadeIn(0.001);
                    $(".checktr").fadeIn(0.001);
                    $(".closeBtn").fadeIn(0.001);
                    $(".checkdata").fadeOut(0.0001);
                    $(".checkupdate").fadeOut(0.0001); 
                    $(".checkdelete").fadeOut(0.0001);  
                    return false;  
                }
            });
            $('#koshinBtn, #deleteBtn').on('click',function(){
                var product_id = document.forms["koshinform"]["productId"].value;
                var is_deleted = document.forms["shosaiform"]["is_deleted"].value;
                document.getElementById("checkvalue").innerHTML = "在庫ID"+"("+product_id+")、";
                if(is_deleted == "無効" && product_id != ""){
                    $(".modal_class").fadeIn(0.001);
                    $(".checkupdate").fadeIn(0.001);
                    $(".closeBtn").fadeIn(0.001);
                    $(".checktr").fadeOut(0.0001);
                    $(".checkdata").fadeOut(0.0001);
                    $(".checkdelete").fadeOut(0.0001);      
                return false;
            }
            });

        });

        function deleteFunction(){
            $(document).on('click','#kakuninBtn', function(){
                $(".modal_class").fadeOut(0.0001);
                return true;
            });  
        }
        $(document).on('click','#cancelBtn', function(){
            $(".modal_class").fadeOut(0.0001);
        });   
        function deleteEvent(){
            var product_id = document.forms["deleteform"]["productId"].value;   
            $(".modal_class").fadeIn(0.001);
            $(".checkdelete").fadeIn(0.001);
            $(".checkupdate").fadeOut(0.0001);
            $(".checktr").fadeOut(0.0001);
            $(".checkdata").fadeOut(0.0001);
            $(".closeBtn").fadeOut(0.0001);
            document.getElementById("deletevalue").innerHTML = "在庫ID"+"("+product_id+")、";
        }
    </script>
</head>
<body>
    <h1>商品マスタ一覧表示</h1>
    <hr width="80%">
    <?php
        //データに接続する
        include "dataConnect.php";
        $product_type_name = "";
        $message = "";
        $where = "";
        if(!isset($_POST["kakuninBtn"])){           //削除動作確認
        }else{
            $id = trim($_POST["productId"]);       //商品IDを取得
            $updated_at = date("Y-m-d H:i:s");     //更新日を設定
            $update = "UPDATE product_master SET updated_at = '$updated_at', is_deleted = '1' WHERE id='$id'";
            $dataupdate = $connect->query($update); //クエリ実行
        }     
        if(!isset($_GET["kensakuBtn"])){            //検索動作確認
            $select = "SELECT * FROM product_master WHERE is_deleted = '0'";       //商品情報をセレクト
            $data = $connect->query($select);       //クエリ実行
            $countData = mysqli_num_rows($data);    //データの存在確認
            if($countData==0){                      //データが存在しない場合
                $message = "データが存在しません。";  //メッセージ設定
                echo "<style>.table_class{display:none;}</style>";      //テーブルが非表示設定                  
                goto outputMsg;
            }
        }else{
            //検索条件設定     
            if(trim($_GET["id"])!=""){                  //商品IDの入力を確認
                $product_id = trim($_GET["id"]);        //入力した値を取得
                $where .= " id LIKE '%$product_id%'";   //検索条件を追加
            }else{
                $where .= " id IS NOT NULL";            //商品IDを未入力する案件を設定
            }
            if(trim($_GET["product_type_id"])!=""){     //商品種別IDの入力を確認
                $product_type_id = trim($_GET["product_type_id"]);  //入力した値を取得
                $where .= " AND product_type_id LIKE '%$product_type_id%'";     //検索条件を追加
            }
            if(trim($_GET["product_type_name"])!=""){   //商品種別名を選択確認
                $product_type_name = trim($_GET["product_type_name"]);  //選択した値を取得
                //取得した商品種別名に基づて、商品種別情報をセレクト
                $selproduct_type_id = "SELECT id, type_id, type_number FROM product_type_master WHERE name = '$product_type_name '";
                $dataselproduct_type_id = $connect->query($selproduct_type_id);     //クエリ実行
                foreach($dataselproduct_type_id as $value){
                    $id = $value["id"];                    //商品種別IDを取る
                    $type_id = $value["type_id"];          //種別を取る
                    $type_number = $value["type_number"];  //種別Noを取る
                }
                if($type_number!=1){                       //商品種別名は大項目以外場合
                    $where .= " AND product_type_id = '$id'";  //検索条件を追加
                }else{
                    $where .= " AND product_type_id LIKE '$type_id%'";      //商品種別名は大項目場合
                }            
            }
            if(trim($_GET["name"])!=""){                   //商品名の入力を確認
                $name = trim($_GET["name"]);               //商品名を取得
                $where .= " AND name LIKE '%$name%'";      //検索条件を追加
            }
            if(isset($_GET["is_deleted"])){                //削除済みフラグを確認
                $is_deleted = 1;                           //削除フラグを設定
                $where .= " AND is_deleted = 1";           //検索条件を追加
                $select = "SELECT * FROM product_master WHERE $where";          //削除済みの商品情報ををセレクト
                echo "<style>.koshinBtn,.deleteBtn{display:none;}</style>";     //更新ボタンと削除ボタンを非表示にする
            }else{
                $select = "SELECT * FROM product_master WHERE is_deleted = 0 AND $where";   //削除済み以外の商品情報をセレクト
            }          
            $data = $connect->query($select);       //クエリ実行
            $countData = mysqli_num_rows($data);    //存在するデータを確認
            if($countData==0){                      //データが存在しない場合
                $message = "該当するデータが存在しません。";            //メッセージ設定
                echo "<style>.table_class{display:none;}</style>";    //テーブルに非表示にする
                goto outputMsg;
            }
        }
        outputMsg:                      //メッセージを出力
        echo "<h5>".$message."</h5>";
    ?>
    <div class="modal_class">
        <div class="kakuninMsg">
            <div class="checktr">
                <h3>在庫情報を選択してください。</h3><br><br>
            </div>
            <div class="checkdata">
                <h3>データが存在しません</h3><br><br>
            </div>
            <div class="checkupdate">               
                <h3><div id="checkvalue"></div>この在庫の情報を削除した為、<br>削除と更新ができません。</h3>
            </div>
            <div class="checkdelete">
                <h3><div id="deletevalue"></div>この在庫の情報を削除しますか？</h3>
                <div class="checkBtn">
                    <form name="deleteform" id="deleteform" method="POST" onsubmit="return deleteFunction()">
                        <input id="productId" name="productId" type="hidden" value="">
                        <input id="kakuninBtn" name="kakuninBtn" type="submit" value="OK">               
                    </form>
                </div>
                <div class="cancelBtn">   
                    <button id="cancelBtn">キャンセル</button>            
                </div>
            </div>
            <div class="closeBtn">
                <button id="okBtn">OK</button>
            </div>
        </div>
    </div>
    <div class="product_master_detail">
        <form action="product_master_detail.php" method="GET">
            <input id="countData" type="hidden" value="<?php if(isset($countData)){echo $countData;} ?>">
            <label>商品ID<input id="id" name="id" maxlength="8" value="<?php if(!empty($_GET["id"])){echo $_GET["id"];}?>"/></label>
            <label>商品種別ID<input id="product_type_id" name="product_type_id" maxlength="4" value="<?php if(!empty($_GET["product_type_id"])){echo $_GET["product_type_id"];}?>"/></label><br>
            <label>商品種別名
                <select class="product_type_name" name="product_type_name">
                        <option value = "">(検索条件無し)</option>
                    <?php
                    //現在の商品種別名をセレクト、商品種別IDを取得するため 
                    $selectName = "SELECT name,id FROM product_type_master WHERE is_deleted = '0'";
                    $dataName = $connect->query($selectName);   //クエリ実行
                    foreach($dataName as $value){ ?>
                        <option value="<?php echo $value["name"];?>" <?php if($product_type_name == $value["name"]){echo "selected";}?>> <?php echo $value["name"];?></option>
                    <?php } ?>
                </select>
            </label>
            <label>商品名<input id="name" name="name" value="<?php if(!empty($_GET["name"])){echo $_GET["name"];}?>"/></label><br>
            <label>削除済みフラグ<input id="is_deleted" name="is_deleted" type="checkbox" <?php if(isset($_GET["is_deleted"])){echo "checked";}?>/></label><br>
            <input id="kensakuBtn" name="kensakuBtn" type="submit" value="検索">
        </form>
        <div class="classBtn">
            <form name="shosaiform" action="product_master_shosai.php" method="GET">
                <input id="getUrl1" name="getUrl" type="hidden" value="<?php echo $_SERVER["QUERY_STRING"]; ?>">
                <input name="is_deleted" type="hidden" value="">
                <input id="productId" name="productId" type="hidden" value="">
                <input id="shosaiBtn" type="submit" value="詳細表示">
            </form>
            <form name="koshinform" action="editproduct_master.php" method="GET">
                <input id="getUrl2" name="getUrl" type="hidden" value="<?php echo $_SERVER["QUERY_STRING"]; ?>">
                <input id="productId" name="productId" type="hidden" value="">
                <input id="koshinBtn" type="submit" value="更新">
            </form>
            <form>
                <input id="deleteBtn" name="deleteBtn" type="button" onClick="deleteEvent()" value="削除">
            </form>
        </div>
        <div class="backBtn">
        <form action="product_master_kanri.php" method="POST">
            <input id="backBtn" name="backBtn" type="submit" value="戻る">
        </form>
    </div>
    </div>
    <div class="table_class">
        <table id="table">
            <tr>
                <th>商品ID</th>
                <th>商品種別ID</th>
                <th>商品種別名</th>
                <th>商品名</th>
                <th>価格</th>
                <th>賞味期限日数</th>
                <th>更新日</th>
                <th>状態</th>
            </tr>
            <?php foreach($data as $value){ ?>
                <?php
                    $subId = $value["product_type_id"];         //商品種別IDを取得
                    $selName = "SELECT name FROM product_type_master WHERE id= '$subId'";   //商品種別名をセレクト
                    $dataselName = $connect->query($selName);   //クエリ実行
                    foreach($dataselName as $key){  
                        $subName = $key["name"];                //商品種別名を取る
                    }
                ?>
                <tr>   
                <td><?php echo $value["id"]; ?></td>
                <td><?php echo $value["product_type_id"]; ?></td>
                <td><?php echo $subName; ?></td>
                <td><?php echo $value["name"]; ?></td>
                <td><?php echo "¥".$value["price"]; ?></td>
                <td><?php echo $value["shelf_life_days"]."日"; ?></td>
                <td><?php echo $value["updated_at"]; ?></td>
                <td><?php if($value["is_deleted"]==0){echo "有効";}else{echo "無効";} ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
