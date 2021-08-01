$(document).ready(function(){
    $("#type").change(function(){                   
        $.ajax({
            url:"select_product_type_id.php",
            type:"POST",
            data:{id: $(this).val()}
        }).done(function(data){
            $("#product_type_name").html(data);
            $("#product_type_id").val(""); //商品種別IDは空にする
        }).fail(function(html){
            alert("error");
        });
    });
});
$(document).ready(function(){
    $("#product_type_name").change(function(){
        $.ajax({
            url:"Ajaxproduct_type_id.php",
            type:"POST",
            data:{product_type_name:$(this).val()}
        }).done(function(data){
            $("#product_type_id").val(data);
            $("#product_type_id_hidden").val(data);
        }).fail(function(html){
            alert("error");
        });
    });
});
$(document).on('click','#closeBtn',function(){
    $('.modal_message').fadeOut(0.0001);
});
$(document).on('click','.close',function(){
    $('.modal_toroku').fadeOut(0.001);
});
function torokuFunction(){
    var type = document.getElementById("type").value;
    var product_type_name = document.getElementById("product_type_name").value;
    document.getElementById('idh5').style.display = "none";
    if(type==""){
        $('.modal_message').fadeIn(0.001);
        $('#type_class').fadeIn(0.001);
        document.getElementById("product_type_class1").style.display = "none";
        document.getElementById("product_type_class2").style.display = "none";
        return false;
    }else if(product_type_name==""){             
        $('.modal_message').fadeIn(0.001);
        $('#product_type_class1').fadeIn(0.001);
        document.getElementById("type_class").style.display = "none";
        document.getElementById("product_type_class2").style.display = "none";            
        return false;
    }else if(product_type_name=="データ無し"){
        $('.modal_message').fadeIn(0.001);
        $('#product_type_class2').fadeIn(0.001);
        document.getElementById("type_class").style.display = "none";
        document.getElementById("product_type_class1").style.display = "none";          
        return false;
    }
}