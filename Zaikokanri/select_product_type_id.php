
<?php
    //データに接続する
    include "dataConnect.php";
    if(isset($_POST["id"])){                    //商品マスタ登録画面からデータの取得を確認
        $name1 = trim($_POST["id"]);            //種別を取得(商品種別名の大項目)
        //種別IDをセレクト
        $select1 = "SELECT type_id FROM product_type_master WHERE name = '$name1' AND is_deleted=0";  
        $data1 = $connect->query($select1);     //クエリ実行
        $count1 = mysqli_num_rows($data1);
        if($count1!=0){
            $row1 = mysqli_fetch_array($data1);      //データの連想配列を取得
            $type_id1 = $row1["type_id"];             //種別IDを取る
        }else{
            $type_id1 = "";
        }
        $selectType_id = "SELECT type_id FROM product_type_master WHERE type_id='$type_id1' AND is_deleted=0";
        $dataType_id = $connect->query($selectType_id);
        $countType_id = mysqli_num_rows($dataType_id);
        if($countType_id==1){
            echo "<option>データ無し</option>";
        }else{
        //取った種別によって、大項目以外の種別名をセレクト
            $select2 = "SELECT name FROM product_type_master WHERE type_id = '$type_id1' AND type_number <> 1 AND is_deleted=0";  
            $data2 = $connect->query($select2);     //クエリ実行
            echo "<option></option>";
            foreach($data2 as $value){
                $name2 = $value["name"];            //商品種別名を取る
                echo "<option>".$name2."</option>";
            }   
        }  
    }
    if(isset($_POST["type_id"])){
        $type_id = trim($_POST["type_id"]);
        $selectType_id = "SELECT type_id FROM product_type_master WHERE type_id='$type_id'";
        $dataType_id = $connect->query($selectType_id);
        $count = mysqli_num_rows($dataType_id);
        if($count==0){
            $rownum = "001";
        }else{
            $count += 1;
            $rownum = str_pad($count,3,'0',STR_PAD_LEFT);    
        }
        echo $rownum;
    }
    if(isset($_POST["type_ids"])){
        $type_ids = trim($_POST["type_ids"]);
        if($type_ids==""){
            $rownum = "";
        }else{
            $rownum = "001";   
        }
        echo $rownum;
    }
    if(isset($_POST["type_name"])){
        $name = trim($_POST["type_name"]);
        $selectType_id = "SELECT type_id FROM product_type_master WHERE type_number=1 AND is_deleted=0";
        $dataType_id = $connect->query($selectType_id);
        $row = array();    
        foreach($dataType_id as $value){
            $row[] = $value["type_id"];
        }
        if($name==""){
            include "zalphabet.php";
            $result = array_diff($alphabet_array, $row);
            echo "<option></option>";
            foreach($result as $key){
                echo "<option>".$key."</option>";          
            }
        }else{
            $selectType = "SELECT type_id FROM product_type_master WHERE name='$name'";
            $dataType = $connect->query($selectType);
            $resuilt = mysqli_fetch_array($dataType);
            $type_id = $resuilt["type_id"];
            echo "<option>".$type_id."</option>";          
        }    
    }
    if(isset($_POST["numberId"])&& isset($_POST["type_ids"])){
        $numberid = trim($_POST["numberId"]);
        $type_ids = trim($_POST["type_ids"]);
        if($numberid=="001"){
            $value = "新規登録";
        }else{
            $selectName = "SELECT name FROM product_type_master WHERE type_id='$type_ids' and type_number=1";
            $dataName = $connect->query($selectName);
            foreach($dataName as $key){
                $value = $key["name"];
            }
        }
        echo "<option>".$value."</option>";
    }
    //在庫登録画面からデータを取得
    if(isset($_POST["type"])){          //選択した種別の取得を確認
        $type = trim($_POST["type"]);   //種別を取得
        //取得した種別によって、種別IDをセレクト
        $selectType_id1 = "SELECT type_id FROM product_type_master WHERE name='$type' AND is_deleted=0";
        $dataType_id1 = $connect->query($selectType_id1);       //クエリ実行
        //種別の種別名が一つ以上が存在する種別IDをセレクト
        $selectType_id2 = "SELECT type_id FROM product_type_master WHERE type_number=2 AND is_deleted=0";
        $dataType_id2 = $connect->query($selectType_id2);       //クエリ実行
        $row = array();         //種別名の配列宣言
        foreach($dataType_id2 as $key){
            $type_id2 = $key["type_id"];    //種別IDを取る
            //取った種別IDによって、種別名をセレクト
            $selectName1 = "SELECT name FROM product_type_master WHERE type_id='$type_id2' AND type_number=1 AND is_deleted=0";
            $dataName1 = $connect->query($selectName1);   //クエリ実行
            foreach($dataName1 as $value){
                $row[] = $value["name"];                  //種別名を取る（配列の中に入れる）
            }
        }
        if($type==""){                  //種別を未選択場合
            echo "<option></option>";
        }elseif(in_array($type, $row, true)==false){        //選択した種別の種別名の大項目しか存在しない場合
            echo "<option>データ無し</option>";
        }else{
            foreach($dataType_id1 as $value){
                echo "<option></option>";
                $type_id = $value["type_id"];               //種別を取る
                //取った種別によって、種別名をセレクト（大項目含まず）
                $selectName = "SELECT name FROM product_type_master WHERE type_id='$type_id' AND type_number <> 1 AND is_deleted='0'";
                $dataName = $connect->query($selectName);   //クエリ実行
                foreach($dataName as $key){
                    $name = $key["name"];                   //商品名を取る
                    echo "<option>".$name."</option>"; 
                }        
            }
        }
    }
    if(isset($_POST["product_id"])){
        $product_id = trim($_POST["product_id"]);
        $selectId = "SELECT id FROM product_type_master WHERE name='$product_id' AND is_deleted='0'";
        $dataId = $connect->query($selectId);
        $count = mysqli_num_rows($dataId);
        if($count!=0){
            $result1 = mysqli_fetch_array($dataId);
            $id = $result1["id"];
            $selectProduct_name = "SELECT name FROM product_master WHERE product_type_id='$id' AND is_deleted='0'";
            $dataSelect = $connect->query($selectProduct_name);
            $countName = mysqli_fetch_array($dataSelect);
            if($countName==0){
                echo "<option>データ無し</option>";
            }else{
                echo "<option></option>";
                foreach($dataSelect as $value){
                    echo "<option>".$value["name"]."</option>";
                } 
            }        
        }             
    }
    if(isset($_POST["product_name"])){
        $product_name = trim($_POST["product_name"]);
        $selectType = "SELECT product_type_id FROM product_master WHERE name='$product_name' AND is_deleted=0";
        $dataType = $connect->query($selectType);
        $result = mysqli_fetch_array($dataType);
        $product_type_id = $result["product_type_id"];
        echo "<option>".$product_type_id."</option>";
    }
    if(isset($_POST["product_type"])){
        $product_type = trim($_POST["product_type"]);
        $selectName = "SELECT name FROM product_type_master WHERE id='$product_type' AND is_deleted=0";
        $dataName = $connect->query($selectName);
        $result = mysqli_fetch_array($dataName);
        $name = $result["name"];
        echo "<option>".$name."</option>";  
    }

?>
