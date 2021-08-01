<?php
    include "dataConnect.php";
    if(isset($_POST["product_type_name"])){
        $product_type_name = trim($_POST["product_type_name"]);
        if($product_type_name==""){
            echo "";
        }else{
            $selectId = "SELECT id FROM product_type_master WHERE name='$product_type_name' AND is_deleted=0";
            $dataId = $connect->query($selectId);
            $result = mysqli_fetch_array($dataId);
            $id = $result["id"];
            echo $id;
        }
      
    }
?>
