<!DOCTYPE Html>
<html>
<head>
    <title>ユーザ一覧</title>
    <style>
        body{
            background-color:lightcyan;
        }
        h1,h3,h5{
            text-align:center;
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
        table,tr,th,td{
            border:1px solid black;
        }
        td{
            min-width: 150px;
            height: 35px;
        }
        th{
            color:Blue;
        }
        table{
            margin-top:50px;
            margin-left: 35px;
            text-align: center;
            background-color: white;
        }
        .backBtn{
            margin-top: 50px;
            margin-left: 350px;
        }
        .userichiran{
            width:400px;
            margin: auto;
        }
        #koshinBtn{
            margin-left: 35px;
            margin-top: 50px;
        }
        #backBtn,#koshinBtn{
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
        .modal_class{
            background-color: rgba(50, 50, 50, 0.7);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;
        }
        .kakuninMsg{
            border: 1px solid brown;
            position:absolute;
            width: 450px;
            height: 150px;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%);
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
            $("#usertable tr:not(:first)").on('click',function(){
                var table_value = $(this).closest("tr");
                var userId = table_value.find("td:eq(0)").html();
                var clicked = $(this).hasClass("selected");
                $("#usertable tr").removeClass("selected");
                if(!clicked){
                    $(this).addClass("selected");
                    document.getElementById("koshinID").value = userId;
                }else{
                    document.getElementById("koshinID").value = "";
                }
            });
            $("#okBtn").on('click',function(){
                $('.modal_class').fadeOut(0.0001);
            });
        });
        function koshinFunction(){
            var count = document.getElementById("count").value;
            var userId = document.getElementById("koshinID").value;
            if(count == 0){
                $('.modal_class').fadeIn(0.001);
                $('.checkdata').fadeIn(0.001);
                $('.checktr').fadeOut(0.0001);
                //alert("ユーザ情報が存在しません");
                return false;
            }else if(userId==""){
                $('.modal_class').fadeIn(0.001);
                $('.checktr').fadeIn(0.001);
                $('.checkdata').fadeOut(0.0001);        
                //alert("ユーザ情報を選択してください。");
                return false;
            }
        }
    </script>
</head>
<body>
    <h1>ユーザマスタ一覧表示</h1>
    <hr width="30%">
    <?php
        //データに接続する
        include "dataConnect.php";
        //ユーザ情報をセレクト
        $select = "SELECT * FROM user_master WHERE is_deleted = '0' ORDER BY id";
        $data = $connect->query($select);       //クエリ実行
        $count = mysqli_num_rows($data);        //データの行を確認
        if($count==0){                          //データが存在しない場合
            echo "<h5>ユーザ情報が存在しません。</h5>";
            echo "<style>#usertable{display:none;}</style>";
        }
    ?>
        <div class="modal_class">
        <div class="kakuninMsg">
            <div class="checktr">
                <h3>ユーザ情報を選択してください。</h3>
            </div>
            <div class="checkdata">
                <h3>ユーザ情報が存在しません。</h3>
            </div>
            <div class="closeBtn">
                <button id="okBtn">OK</button>
            </div>
        </div>
    </div>
    <div class="userichiran">
        <table id="usertable">
            <tr>
                <th>ユーザID</th>
                <th>ユーザ名</th>
            </tr>
            <?php foreach($data as $value){?>
            <tr>
                <td><?php echo $value["id"]; ?></td>
                <td><?php echo $value["name"]; ?></td>
            </tr>
            <?php } ?>    
        </table>
        <div class="koshinclass">
            <input id="count" type="hidden" value="<?php echo $count; ?>"/>
            <form name="koshinform" action="edituser.php" method="POST" onsubmit="return koshinFunction()">
                <input id="koshinID" name="koshinID" type="hidden" value="">
                <input id="koshinBtn" name="koshinBtn" type="submit" value="更新">
            </form>
        </div>
        <div class="backBtn">
            <form action="user_master_kanri.php" method="POST">          
                <input id="backBtn" name="backBtn" type="submit" value="戻る">
            </form>  
        </div>
    </div>

</body>
</html>
