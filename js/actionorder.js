$(document).ready(function(){
    
    //cannot insert site name
    $("#code").prop("disabled",true);
    $("#test").blur(function(){
        if($("#test").val().length == 4){
            $("#code").prop("disabled",true);
        }
        else{
            $("#code").prop("disabled",false);
        }
    })
    if($("#test").val().length == 4){
        $("#code").prop("disabled",true);
    }
    else{
        $("#code").prop("disabled",false);
    }

    $('#btnorder').prop("disabled",true);
    $("#code").change(function(){
        var productvalue = $(this).val();
        // alert(productvalue);
        
        $.ajax({
            url: "actionOrder.php",
            method: "GET",
            data: {productvalue:productvalue},
            success: function(data){
                if(data == ""){
                    $("#btnorder").prop("disabled",true);
                    // $("#pas").prop("disabled",true);
                    swal("Attention","Invalid product code","error");     
                }
                
                else{
                    $("#productname").val(data);
                    $("#btnorder").prop("disabled",false);
                    // $("#pas").prop("disabled",false);

                }
            }
        })

    })


});
