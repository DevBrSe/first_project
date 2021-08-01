<!DOCTYPE Html>
<html>
<head>
    <title>商品種別一覧</title>
    <link rel="stylesheet" href="Css/product_type_list.css">
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
            color:red;
        }
        input{
            width: 200px;
            height: 25px;
            margin: 20px;
        }
        #type{
            width: 200px;
            height: 30px;
            margin: 20px;
        }
        label{
            color:mediumblue;
        }
        .product_type_list{
            width: 410px;
            margin:auto;
        }
        .kensaku_class{
            width: 650px;
            margin:auto;
        }
        table,tr,th,td{
            border:1px solid black;
        }
        td,th{
            max-width: 250px;
            height: 35px;
            min-width: 170px;
        }
        th{
            color:navy;
        }
        table{
            margin-top:50px;
            margin-left: 35px;
            text-align: center;
            background-color:white;
        }
        #kensakuBtn{
            margin-left: 60px;
        }
        #shosaiBtn{
            margin-top: 25px;
            margin-left: 60px;
        }  

        .backBtn{
            margin-top: -90px;
            margin-left: 480px;
        }
        #backBtn,#shosaiBtn,#kensakuBtn{
            width: 100px;
            height: 50px;
            border-radius: 2px;
            font-size: 20px;
            background-color:royalblue;
            color:white;
        }
        .selected{
            background-color:aquamarine;
            color:firebrick;
        }
        #product_table{
            margin-bottom: 50px;
        }
        .modal_class{
            position: fixed;
            background-color: rgba(50, 50, 50, 0.7);
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
            top: 40%;
            left: 50%;
            transform: translate(-50%,-50%);
            background-color: white;
            border-radius: 6px;
        }
        #okBtn{
            width: 70px;
            height: 35px;
            border-radius: 6px;
            background-color:royalblue;
            color:white;
        }
        .closeBtn{
            float: right;
            margin-right: 10px;
            font-size: 20px;
            cursor: pointer;
            margin-top: 35px;
        }

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#product_table tr:not(:first)").click(function(){
                var row_value = $(this).closest("tr");
                var type_id = row_value.find("td:eq(0)").html();
                var checked = $(this).hasClass("selected");
                $("#product_table tr").removeClass("selected");
                if(!checked){
                    $(this).addClass("selected");
                    document.forms["shosaiform"]["shosaiId"].value = type_id;    
                }else{
                    document.forms["shosaiform"]["shosaiId"].value = "";
                }
            });
            $('#okBtn').on('click',function(){
                $('.modal_class').fadeOut(0.0001);
            });
        });
        function shosaiFunction(){
            var val_type_id = document.forms["shosaiform"]["shosaiId"].value;
            var count = document.getElementById("count").value;
            if(count == 0){
                $('.modal_class').fadeIn(0.001);
                $('.checktr').fadeOut(0.0001);
                $('.checkdata').fadeIn(0.001);
                return false;
            }else if(val_type_id=="" ){
                $('.modal_class').fadeIn(0.001);
                $('.checktr').fadeIn(0.001);
                $('.checkdata').fadeOut(0.0001);
                return false;
            }
        }
    </script>
</head>
<body>
    <h1>商品種別マスタ一覧表示</h1>
    <hr width="40%">
    <?php
        //データに接続する
        include "dataConnect.php";
        $message = "";
        if(!isset($_GET["kensakuBtn"])){        //検索動作確認
            $type = "";
            $product_type_name = "";
            $select = "SELECT * FROM product_type_master WHERE is_deleted='0'";     //商品種別情報をセレクト
            $data = $connect->query($select);    //クエリ実行
            $count = mysqli_num_rows($data);     //データの存在確認
            if($count==0){
                $message = "商品種別データが存在しません。";         //エラーメッセージ設定
                goto outputMsg;        
            }     
        }else{
            $type = trim($_GET["type"]);                            //種別を取得
            $product_type_name = trim($_GET["product_type_name"]);  //商品種別名を取得
        }
        $where = "";
        if($type==""){                          //種別を未選択
            $where .= " type_id IS NOT NULL";   //検索条件を設定
        }else{
            //種別IDをセレクト
            $selectType_id = "SELECT type_id FROM product_type_master WHERE name='$type' AND is_deleted=0";
            $dataType_id = $connect->query($selectType_id);         //クエリ実行
            $result = mysqli_fetch_array($dataType_id);             //データの連想配列を取得
            $type_id = $result["type_id"];                          //種別IDを取る
            $where .= " type_id = '$type_id'";  //検索条件を追加
        }                 
        if($product_type_name!=""){             //商品種別名の入力を確認
            $where .= " AND name LIKE '%$product_type_name%'";      //検索条件を追加
        }
        //検索条件によって、商品種別情報をセレクト
        $select = "SELECT * FROM product_type_master WHERE $where AND is_deleted='0'";
        $data = $connect->query($select);                           //クエリ実行
        $count = mysqli_num_rows($data);                            //データの存在を確認
        if($count==0){                                              //データが存在しない場合
            $message = "該当するデータが存在しません。";               //eエラーメッセージ設定
            goto outputMsg;     
        }
        outputMsg:                          //エラーメッセーを出力
        if($message != ""){                 //エラーメッセーが存在しない場合
            echo "<h5>".$message."</h5>";
            echo "<style>#product_table{display:none;}</style>";
        }
    ?>
        <div class="modal_class">
        <div class="kakuninMsg">
            <div class="checktr">
                <h3>商品種別情報を選択してください。</h3>
            </div>
            <div class="checkdata">
                <input id="count" type="hidden" value="<?php echo $count ?>"/>
                <h3>商品が存在しません。</h3>
            </div>
            <div class="closeBtn">
                <button id="okBtn">OK</button>
            </div>
        </div>
    </div>
    <div class="kensaku_class">
        <form action="product_type_list.php" method="GET">
            <label>種別
                <select id="type" name="type">
                    <option></option>
                    <?php
                        //存在する種別名の大項目をセレクト
                        $selectType = "SELECT name FROM product_type_master WHERE type_number = 1 AND is_deleted=0";
                        $dataType = $connect->query($selectType);   //クエリ実行
                        foreach($dataType as $value){
                            $name = $value["name"];                 //種別名を取る
                            if($type==$name){
                                echo "<option selected>".$name."</option>";
                            }else{
                                echo "<option>".$name."</option>";
                            }
                        }
                    ?>
                </select>
            </label>
            <label>商品種別名
                <input id="product_type_name" name="product_type_name" value="<?php if(isset($product_type_name)){echo $product_type_name;}?>"/>
            </label><br>
            <input id="kensakuBtn" name="kensakuBtn" type="submit" value="検索">
        </form>
        <form name="shosaiform" action="editproduct_type.php" method="GET" onsubmit="return shosaiFunction()">
            <input id="getUrl" name="getUrl" type="hidden" value="<?php echo $_SERVER['QUERY_STRING']; ?>"/>
            <input id="shosaiId" name="shosaiId" type="hidden" value=""/>
            <input id="shosaiBtn" name="shosaiBtn" type="submit" value="詳細表示"/>
        </form>
        <div class="backBtn">
            <form action="product_type_kanri.php" method="POST">
                <input id="backBtn" name="backBtn" type="submit" value="戻る">
            </form>
        </div>
    </div>
    <div class="product_type_list">    
        <table id="product_table">
            <tr>
                <th>種別ID</th>
                <th>商品種別名</th>
            </tr>
            <?php
                if(isset($_GET["pageNo"])){
                    $pageNo = trim($_GET["pageNo"]);
                }else{
                    $pageNo = 1;
                }
                $pageLimit = 10;
                $total_pages = ceil($count/10);
                $sql = "SELECT * FROM product_type_master WHERE $where AND is_deleted='0' LIMIT $pageNo, $pageLimit";
                $data1 = $connect->query($sql);   
                foreach($data1 as $value){ 
            ?>
            <tr>
                <td><?php echo $value["id"]; ?></td>
                <td><?php echo $value["name"]; ?></td>
            </tr>
        <?php } ?>
        </table>
            <?php
                $page = 1;
                if($total_pages>1){
                    echo "Page";               
                    for($i = 1; $i <= $total_pages; $i++){                                           
                        echo "<a href='?pageNo=$page'>$i</a>";                                  
                        $page += 10;
                    }                
                }
            ?>        
    </div>
</body>
</html>
