$(document).ready(function(){

    var prefix, detail, data1, bal, total,tl;
   
    // prefix = $(".btnEdit").data('id');


    $(".btnEdit").click(function(){
        prefix = $(this).data('id');

        // quantity
        detail = $(this).data('qid');
        
        // holdsfree
        data1 = $(this).parents('tr').find('td input.holds').val(); 

        // if( data1 > detail){
        //     Swal.fire("Holds free must be less than ordered quantity");
        // }else{
            
        //disabled approve button enable
            $(this).parents('tr').find('td > button.btnApprove').prop('disabled',false);
            
            // $(this).parents('tr').find('td > button.btnApprove').click(function(){
            //     // $(this).parents('tr').find('td > input.holds').prop('disabled',true);
            //     data1 = $(this).parents('tr').find('td input.holds').val();
            //     if(data1 == ""){
            //         alert("kindly input holdsfree amount");
            //     }else{
            //         $(this).parents('tr').find('td > input.holds').prop('disabled',true);
                    
            //     }

            // });
            
            //checking null value of holdsfree input
            if(data1 == ""){
                Swal.fire("Null value of holdfree not allowed")
            }
            else{
                total = detail-data1;
                $(this).parents('tr').find('td.balance').text(total);
                // balance
                bal = $(this).parents('tr').find('td.balance').text();
            }  
        }
    )    

    $(".btnApprove").parents('tr').find('td > button.btnApprove').click(function(){
        // $(this).parents('tr').find('td > input.holds').prop('disabled',true);
        data1 = $(this).parents('tr').find('td input.holds').val();
        tl = $(this).parents('tr').find('td select.carrier').val();
        if(data1 == ""){
            Swal.fire("Kindly input holdsfree amount");
            bal = $(this).parents('tr').find('td.balance').text("");
        }else{
            $(this).parents('tr').find('td > input.holds').prop('disabled',true);
            $(this).parents('tr').find('td select.carrier').prop('disabled',true);

            // console.log("prefix"+prefix+"\n"+"holdsfree"+data1+"\n"+"balance"+bal);
            Swal.fire({title:"Your data has been approved",
                       confirmButtonText:"OK"
                        }).then((result=>{
                            if(result.isConfirmed){
                                window.location.reload();
                            }else{

                            }
                        }));     
            $.ajax({
                url: "actionAdminTransaction.php",
                method: "GET",
                data: {data1:data1,bal:bal,prefix:prefix,tl:tl},
                success: function(data){
                    var data = JSON.parse(data);
                    // Swal.fire("Your data has been approved");     
                }

            })

        }

    });

    // $("#balance").click(function(){
    //     // Swal.fire({html:'Balance:  <?= number_format( $res2["Balance"],2);?> <br><br>  Credit Limit: <?= number_format( $res2["Credit_Limit"],2);?>',
    //     //             confirmButtonText:'Close'});
    //     // alert("hello world");
    // })

    //disable minus - key of keyboard
    $(".holds").keydown(function(e){
        if(!((e.keyCode > 95 && e.keyCode < 106)
        || (e.keyCode > 47 && e.keyCode < 58) 
        || e.keyCode == 8)) {
          return false;
      }
    })

    //balance credit debit
    $(".credit").click(function(){
        let credit= $(this).data('bid');
        $.ajax({
            url: "actionCredit.php",
            method: "GET",
            data: {credit:credit},
            success: function(data){
                var data = JSON.parse(data);
                Swal.fire({html:`Balance:  ${data.balance} <br><br>  Credit Limit: ${data.credit}<br><br>  Available Credit Limit: ${data.available}`,
                    confirmButtonText:'Close'});
            }

        })

        
    })

});


