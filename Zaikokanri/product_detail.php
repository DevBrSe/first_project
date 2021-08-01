<!DOCTYPE Html>
<html>
<head>
    <title>在庫一覧</title>
    <link rel="stylesheet" href="Css/product_detail.css">
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
            color: blue;
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
        label{
            color:mediumblue;
        }
        #product_id{
            margin-left: 40px;
        }
        #product_type_name{
            margin-left: 27px;
        }
        #price{
            margin-left: 53px;
        }
        .shelf_life_date{
            margin-left:10px;
        }
        #shelf_life_date{
            margin-left: 27px;
        }
        select{
            width: 210px;
            height: 30px;
        }
        #checkbox{
            margin-left: -80px;
        }
        .zaikokensaku{
            width: 700px;
            margin: auto;
        }
        #kensakuBtn{
            margin-left: 85px;
        }
        #kensakuBtn, #backBtn,#deleteBtn,#shosaiBtn,#koshinBtn,#deleteBtn{
            width: 100px;
            height: 50px;
            border-radius: 2px;
            font-size: 20px;
            background-color:royalblue;
            color:white;
        }
        #editform{
            margin-left:-30px;
        }
        #deleteBtn{
            margin-left: -8px;
        }
        .backBtn{
            margin-left: 495px;
            margin-top: -90px;
        }
        table,tr,th,td{
            border: 1px solid black;
        }
        th{
            color:navy;
        }
        .zaikoichiran{         
            margin-bottom: 150px;
            margin-top: 50px;
            min-width: 1050px;
        }
        .formBtn{
            display: flex;
            margin-left: 65px;
        }
        table{
            width: 1250px;
            margin:auto;
            background-color:white;
        }
        .page_class{
            width: 1250px;
            margin: auto;
            margin-top: 10px;
        }
        .pageNo{
            width: 120px;
            margin: auto;
            color:mediumblue;
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
            margin-top: -55px;
        }
        a{
            text-decoration: none;
            color:teal;
            padding: 5px;
        }
        .page_class a:hover{
            background-color:lightblue;
            color:chocolate;
        }
        .pageName{
            color:mediumblue;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){          
        $("#table tr:not(:first)").click(function(){
            var table_value = $(this).closest("tr");
            var id = table_value.find("td:eq(0)").html();
            var checked = $(this).hasClass("selected");
            $("#table tr").removeClass("selected");
            if(!checked){
                $(this).addClass("selected");
                document.forms["newform"]["valueid"].value = id;
                document.forms["editform"]["valueid"].value = id;
                document.forms["deleteform"]["valueid"].value = id;
            }else{
                document.forms["newform"]["valueid"].value = "";
                document.forms["editform"]["valueid"].value = "";
                document.forms["deleteform"]["valueid"].value = "";
            }
        });
        $(".closeBtn").on('click',function(){
            $(".modal_class").fadeOut(0.0001);        
        });
        $('#shosaiBtn, #koshinBtn, #deleteBtn').on('click',function(){
            var countdata = document.getElementById("countdata").value;
            var valid = document.forms["newform"]["valueid"].value;
            if(countdata==0 || countdata ==1){
                $(".modal_class").fadeIn(0.001);
                $(".checkdata").fadeIn(0.001);
                $(".closeBtn").fadeIn(0.001);
                $(".checktr").fadeOut(0.0001);
                $(".checkupdate").fadeOut(0.0001);
                $(".checkdelete").fadeOut(0.0001);  
                return false;
            }
            if(valid==""){    
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
            var valid = document.forms["editform"]["valueid"].value;
            var is_deleted = document.getElementById("is_deleted").value;
            document.getElementById("checkvalue").innerHTML = "在庫ID"+"("+valid+")、";
            if(is_deleted == 1 && valid != ""){
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
        var valid = document.forms["deleteform"]["valueid"].value;   
        $(".modal_class").fadeIn(0.001);
        $(".checkdelete").fadeIn(0.001);
        $(".checkupdate").fadeOut(0.0001);
        $(".checktr").fadeOut(0.0001);
        $(".checkdata").fadeOut(0.0001);
        $(".closeBtn").fadeOut(0.0001);
        document.getElementById("deletevalue").innerHTML = "在庫ID"+"("+valid+")、";
    }
</script>
</head>
<body>
    <h1>在庫一覧表示</h1>
    <hr width="50%"> 
    <?php
        //データに接続する
        include "dataConnect.php";
        $message = "";
        $where = "";
        $tmp = "";
        $temp = "";
        $deleteMsg = "";
        //削除設定  
        if(!isset($_POST["kakuninBtn"])){                //削除動作確認
        }else{  
            $id = trim($_POST["valueid"]);              //在庫IDを取得
            $updated_at = date("Y-m-d H:i:s");          //更新日を設定
            //在庫情報をアップデート
            $updatestock = "UPDATE stock SET is_deleted=1, updated_at='$updated_at' WHERE id='$id'";
            $connect->query($updatestock); //クエリ実行
        }      
        if(!isset($_GET["kensakuBtn"])){
            $selectzaiko = "SELECT * FROM stock WHERE is_deleted = '0'";    //在庫情報をセレクト
        }else{         
            $product_id = trim($_GET["product_id"]);                        //商品IDを取得
            $product_type_name = trim($_GET["product_type_name"]);          //商品種別名を取得
            $price = trim($_GET["price"]);                                  //単価を取得
            $shelf_life_date = date(trim($_GET["shelf_life_date"]));        //賞味期限を取得 
            
            if($product_id==""){                                            //商品IDを未入力場合
                $where .= " product_id IS NOT NULL";                        //検索案件を設定    
            }else{
                $where .= " product_id LIKE '%$product_id%'";               //検索案件を設定  
            }
            if($shelf_life_date!=""){                                       //賞味期限の値を確認
                $where .= " AND shelf_life_date like '%$shelf_life_date%'"; //検索案件を追加
            }
            if($product_type_name==""){                                     //商品名を未選択
            }else{
                //商品種別名によって、商品種別情報をセレクト
                $selectProduct_type_master = "SELECT id, type_id, type_number FROM product_type_master WHERE name='$product_type_name'"; 
                $row = mysqli_fetch_assoc($connect->query($selectProduct_type_master));     //連想配列を取得
                $product_type_id = $row["id"];        //商品種別IDを取る
                $type_id = $row["type_id"];           //種別IDを取る
                $type_number = $row["type_number"];   //種別Noを取る
                if($type_number==1){                  //商品種別名の大項目場合
                    $where .= " AND product_id LIKE '%$type_id%'";
                }else{
                    //商品種別IDによって、商品IDをセレクト
                    $selectProduct_master = "SELECT id FROM product_master WHERE product_type_id='$product_type_id'";
                    $dataProduct_master = $connect->query($selectProduct_master);               //クエリ実行
                    $count_data = mysqli_num_rows($dataProduct_master);                         //セレクトしたデータの行を確認
                    if($count_data==0){
                        $where .= " AND product_id = ''";                                      //データが存在しない場合
                    }else{
                        for($i=0; $i<$count_data; $i++){
                            $result1 = mysqli_fetch_array($dataProduct_master);  //データの連想配列を取得
                            $product_ids = $result1["id"];                       //商品IDを取る
                            //検索案件を追加する
                            if($i==0){
                                $tmp .= "product_id = '$product_ids'";
                            }else{
                                $tmp .= " OR product_id = '$product_ids'";
                            }
                        }
                        $where .= " AND ($tmp)";                                //検索案件を追加
                    }
                }
            }
            if($price==""){                    //単価を未選択
            }else{
                //選択した単価の値を設定
                switch($price){
                    case "0~100":              //0円から100までの商品
                        $left_price = 0;
                        $right_price = 100;
                    break;
                    case "501~1000":           //501円から1000円までの商品
                        $left_price = 501;
                        $right_price = 1000;
                    break;
                    case ">1000":              //1000円から100.0000円までの商品
                        $left_price = 1000;
                        $right_price = 1000000;
                    break;
                    default:                    //その他(この場合は101円から500円までの商品)
                        $left_price = substr($price,'0',3);         //選択した単価の小値を取る
                        $right_price = substr($price,'-3',3);       //選択した単価の大値を取る
                }
                //選択した単価によって、商品IDをセレクト
                $selectprice = "SELECT id FROM product_master WHERE price >= $left_price AND price <= $right_price";
                $dataid = $connect->query($selectprice);            //クエリ実行
                $countid = mysqli_num_rows($dataid);                //データの存在を確認
                if($countid==0){                                    //データが存在しない場合
                    $where .= " AND product_id = ''";               //検索案件を追加
                }else{
                    for($j=0;$j<$countid;$j++){
                        $result2 = mysqli_fetch_array($dataid);     //データの連想配列を取得
                        $product_id2 = $result2["id"];              //商品IDを取る
                        //検索案件を追加
                        if($j==0){
                            $temp .= "product_id = '$product_id2'";
                        }else{
                            $temp .= " OR product_id = '$product_id2'";
                        }
                    }
                    $where .= " AND ($temp)";                        //検索案件を追加
                }
            }        
            if(isset($_GET["is_deleted"])){                          //削除した商品を確認
                $selectzaiko = "SELECT * FROM stock WHERE $where AND is_deleted = '1'";    //在庫情報をセレクト
            }else{
                $selectzaiko = "SELECT * FROM stock WHERE $where AND is_deleted = '0'";    //在庫情報をセレクト   
            }                         
        }
        $datazaiko = $connect->query($selectzaiko);             //クエリ実行
        $countdata = mysqli_num_rows($datazaiko);               //セレクトデータを確認
        if($countdata==0 || $countdata == 1){                   //データがない場合
            $message = "該当するデータが存在しません。";          //メッセージ設定
            echo "<style>.zaikoichiran{display:none}</style>";  //テーブルを非表示にする
        }
        outputMsg:                     //メッセージ出力
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
                        <input id="valueid" name="valueid" type="hidden" value="">
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
    <div class="zaikokensaku">
        <form action="product_detail.php" method="GET">   
            <label>商品ID<input id="product_id" name="product_id" maxlength="8" value="<?php if(isset($product_id)){echo $product_id;}?>"/></label>
            <label>種別名
                <select id="product_type_name" name="product_type_name">
                    <option value=""></option>
                    <?php
                        //存在する種別名をセレクト
                        $selectProduct_type_name = "SELECT name FROM product_type_master WHERE is_deleted = '0'";
                        $dataName = $connect->query($selectProduct_type_name);  //クエリ実行
                        foreach($dataName as $value){
                            $name = $value["name"];
                            if($product_type_name==$name){
                                echo "<option selected>".$name."</option>";         //種別名を取る
                            }else{
                                echo "<option>".$name."</option>";                  //種別名を取る
                            }           
                        }
                    ?>
                </select>
            </label><br>
            <label>単価
                <select id="price" name="price">
                    <option value=""></option>
                    <?php
                        //価格の配列設定
                        $array_value = array("0~100","101~200","201~300","301~400","401~500","501~1000",">1000");
                        $count = count($array_value);
                        for($i=0; $i<$count; $i++){
                            $val = $array_value[$i];
                            if($price == $val){
                                echo "<option selected>".$val."</option>";
                            }else{
                                echo "<option>".$val."</option>";
                            }
                        }
                    ?>         
                </select>      
            </label>
            <label class="shelf_life_date">賞味期限<input id="shelf_life_date" name="shelf_life_date" type="date" 
                    value="<?php if(isset($shelf_life_date)){echo $shelf_life_date;}?>"/></label><br>
            <label>削除フラグ<input id="checkbox" name="is_deleted" type="checkbox" <?php if(isset($_GET["is_deleted"])){echo "checked";} ?>/></label><br>          
            <input id="kensakuBtn" name="kensakuBtn" type="submit" value="検索"/>
        </form>
        <div class="formBtn">
            <input id="countdata" name="countdata" type="hidden" value="<?php  echo $countdata; ?>"/>
            <form id="newform" action="product_shosai.php" method="GET">
                <input id="getUrl" name="getUrl" type="hidden" value="<?php echo $_SERVER['QUERY_STRING']; ?>"/> 
                <input id="valueid" name="valueName" type="hidden" value="">        
                <input id="shosaiBtn" name="shosaiBtn" type="submit" value="詳細表示">
            </form>
            <form id="editform" action="editproduct.php" method="GET">
                <input id="getUrl" name="getUrl" type="hidden" value="<?php echo $_SERVER['QUERY_STRING']; ?>"/>
                <input id="valueid" name="valueid" type="hidden" value="">
                <input id="koshinBtn" name="koshinBtn" type="submit" value="更新"/>
            </form>
            <form>
                <input id="deleteBtn" name="deleteBtn" type="button" value="削除" onClick="deleteEvent()">
            </form>
        </div>
        <div class="backBtn">
            <form action="stock.php" method="POST">
                <input id="backBtn" name="backBtn" type="submit" value="戻る">
            </form>
        </div>
    </div>
    <div class="zaikoichiran">
        <?php
            //ページ目を設定
            if(isset($_GET["pageNo"])){             //データが10行以上場合
                $pageNo = trim($_GET["pageNo"]);    //ページNoを取得
            }else{
                $pageNo = 1;
            }     
            $pageLimit = 10;                        //ページの大きさを設定(最大10行列)
            $total_pages = ceil(($countdata-1)/10); //全ページを計算
            if($total_pages>1){                     //一つページ以上場合
                $page = ($pageLimit + $pageNo - 1)*0.1;             //ページ目を設定
                echo "<div class='pageNo'>".$page."ページ目</div>"; 
            }             
        ?>  
        <table id="table">             
            <tr>
                <th>在庫ID</th>
                <th>種別ID</th>
                <th>種別名</th>
                <th>商品ID</th>
                <th>商品名</th>
                <th>単価</th>
                <th>個数</th>
                <th>入荷日</th>
                <th>賞味期限</th>
                <th>状態</th>
            </tr>
            <?php
            //一覧表示のページを分ける
            if(!isset($_GET["kensakuBtn"])){    //検索しない場合
                //情報をセレクト
                $selectzaiko1 = "SELECT * FROM stock WHERE is_deleted = '0' LIMIT $pageNo, $pageLimit";
            }elseif(isset($_GET["is_deleted"])){ //削除した商品を確認
                 //情報をセレクト
                $selectzaiko1 = "SELECT * FROM stock WHERE $where AND is_deleted = '1' LIMIT $pageNo, $pageLimit";    //在庫情報をセレクト
            }else{
                 //情報をセレクト
                $selectzaiko1 = "SELECT * FROM stock WHERE $where AND is_deleted = '0' LIMIT $pageNo, $pageLimit";    //在庫情報をセレクト   
            }
            $datazaiko1 = $connect->query($selectzaiko1);       //クエリ実行
            foreach($datazaiko1 as $value){
                $product_id = $value["product_id"]; //商品IDを取る
                //商品IDによって、商品名、種別ID,単価をセレクト
                $selectProduct_master = "SELECT name, product_type_id, price FROM product_master WHERE id='$product_id'";
                $dataProduct_master = $connect->query($selectProduct_master);   //クエリ実行
                $count = mysqli_num_rows($dataProduct_master);                  //データの存在を確認
            ?>
            <tr>
                <td><?php echo $value["id"];?></td>
                <input id="selectId" type="hidden" value="<?php echo $value["id"];?>">
                <?php
                if($count!=0){
                    foreach($dataProduct_master as $key){
                        $product_type_id = $key["product_type_id"];     //種別IDを取る
                        echo "<td>".$product_type_id."</td>";           //種別IDを表示
                        //種別IDによって、種別名をセレクト
                        $selectProduct_type_name = "SELECT name FROM product_type_master WHERE id='$product_type_id'";
                        $dataProduct_type_name = $connect->query($selectProduct_type_name);     //クエリ実行
                    }
                    foreach($dataProduct_type_name as $name){
                        echo "<td>".$name["name"]."</td>";              //種別名を表示
                    }
                }
                ?>
                <td><?php echo $value["product_id"];?></td>
                <?php
                if($count!=0){
                    foreach($dataProduct_master as $key){
                        echo "<td>".$key["name"]."</td>";               //商品名を表示
                        echo "<td>¥".$key["price"]."</td>";             //単価を表示
                    }
                }
                ?>
                <td><?php echo $value["stock_quantity"];?></td>
                <td><?php echo $value["arrival_date"];?></td>
                <td><?php echo $value["shelf_life_date"]?></td>
                <td><?php if($value["is_deleted"]==0){echo "有効";}else{echo"無効";}?></td>
                <input id="is_deleted" type="hidden" value="<?php echo $value["is_deleted"]; ?>"/>
            </tr>
        <?php } ?>
        </table>
        <div class="page_class">
            <?php
                //ページを設定
                $page = 1;
                $url = $_SERVER['QUERY_STRING'];                //検索結果のURLを取得
                $url_delete = str_replace("pageNo=","",$url);   //表示したページの情報をURLに削除
                if($total_pages > 1){                           //1ページ以上場合
                    echo "<div class='pageName'>Page:</div>";              
                    for($i = 1; $i<= $total_pages; $i++){                
                        echo "<a href='?pageNo=$page&$url_delete'>$i</a>";  //ページNoのURLを設定
                        $page += 10;              
                    }                    
                }
            ?>
        </div>
    </div> 
</body>
</html>
