// login page script 

let info = document.getElementById("info");
let form = document.getElementById("form");
let logintbn = document.getElementById("loginbtn");
let bg = document.getElementById("bgImage");
let login = document.getElementById('loginNav');

function hide(){
    bg.style.backgroundImage="url('../icon/bg-01.jpg')";
    login.style.display="none";
    form.style.marginTop="150px";
    info.style.display="none";    
    form.style.visibility="visible";
    if(form.style.visibility="visible"){
        logintbn.style.display="none";
    }
    
}

$(document).ready(function(){

    $("#id").blur(function(){
        
        var idvalue = $(this).val();

        // checking hidden field value
        var checkCustomer = $("#checkCustomer").val();
        var checkAdmin = $("#checkAdmin").val();

        // alert(checkCustomer + " - " + checkAdmin)

        if(checkAdmin == 1){
            $.ajax({
                url: "actionadmin.php",
                method: "GET",
                data: {idvalue:idvalue},
                success: function(data){
                    if(data == ""){
                        $("#btnlogin").prop("disabled",true);
                        $("#pas").prop("disabled",true);
                        // alert(data);
                        swal("Attention","Invalid admin ID","error");
                    }else{
                        $("#name").val(data);
                        $("#btnlogin").prop("disabled",false);
                        $("#pas").prop("disabled",false);
    
                    }
                }
            });
        }else if(checkCustomer == 0){
            $.ajax({
                url: "actionUsername.php",
                method: "GET",
                data: {idvalue:idvalue},
                success: function(data){
                    if(data == ""){
                        $("#btnlogin").prop("disabled",true);
                        $("#pas").prop("disabled",true);
                        swal("Attention","Invalid Customer ID","error");
                    }else{
                        $("#name").val(data);
                        $("#btnlogin").prop("disabled",false);
                        $("#pas").prop("disabled",false);
    
                    }
                }
            });
        }else{

        }
       
    })

});
