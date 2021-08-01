$(document).ready(function(){
    $("#type").change(function(){ 
        $.ajax({
            url:"select_product_type_id.php",
            type:"POST",
            data:{type:$(this).val()}
        }).done(function(data){
            $("#product_type").html(data);               
            $("#product_name").html('<option value="">');
        }).fail(function(html){
            alert("error");
        });
    });
});
$(document).ready(function(){
    $("#product_type").change(function(){
    $.ajax({
            url:"select_product_type_id.php",
            type:"POST",
            data:{product_id:$(this).val()}
        }).done(function(data){ 
            $("#product_name").html(data);
        }).fail(function(html){
            alert("error");
        });
    });
});
$(document).on('click','.closeBtn',function(){
    $('.modal-message').fadeOut(0.0001);
});
$(document).on('click','.close',function(){
    $('.modal').fadeOut(0.0001);
});   
function torokuFunction(){
    var type = document.getElementById("type").value;
    document.getElementById("idh5").style.display = "none";
    if(type==""){          
        $('.modal-message').fadeIn(0.001);
        $('#type_class1').fadeIn(0.001);
        document.getElementById("type_class2").style.display = "none";
        document.getElementById("product_type_class1").style.display = "none";
        document.getElementById("product_type_class2").style.display = "none";
        return false;
    }else{
        var product_type = document.getElementById("product_type").value;
        var product_name = document.getElementById("product_name").value;
        if(product_type=="データ無し"){
            $('.modal-message').fadeIn(0.001);
            $('#type_class2').fadeIn(0.001);
            document.getElementById("type_class1").style.display = "none";
            document.getElementById("product_type_class1").style.display = "none";
            document.getElementById("product_type_class2").style.display = "none";
            //alert("("+type+")の商品種別名が存在しない為、\r\n先に商品種別名を登録してください。");
            return false;
        }else if(product_name=="データ無し"){
            $('.modal-message').fadeIn(0.001);
            $('#product_type_class2').fadeIn(0.001);
            document.getElementById("type_class1").style.display = "none";
            document.getElementById("type_class2").style.display = "none";
            document.getElementById("product_type_class1").style.display = "none";
            //alert("("+product_type+")の商品名が存在しない為、\r\n先に商品名を登録してください。");
            return false;
        }else if(product_type=="" || product_name==""){
            $('.modal-message').fadeIn(0.001);
            $('#product_type_class1').fadeIn(0.001);
            document.getElementById("type_class1").style.display = "none";
            document.getElementById("type_class2").style.display = "none";
            document.getElementById("product_type_class2").style.display = "none";
            return false;
        }
    }
}