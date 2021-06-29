$(document).ready(function(){

    var prefix, detail, data1, bal, total;

    $(".btnEdit").click(function(){
        prefix = $(this).data('id');
        
        // quantity
        detail = $(this).data('qid');
        
        // holdsfree
        data1 = $(this).parents('tr').find('td input.holds').val(); 

        if( data1 > detail){
            alert("not allowed");
        }else{
            alert("allowed");
            
            //disabled approve button enable
            $(this).parents('tr').find('td > button.btnApprove').prop('disabled',false);
            $(this).parents('tr').find('td > button.btnApprove').click(function(){
                    $(this).parents('tr').find('td > input.holds').prop('disabled',true);
            });
            

            total = detail-data1;

            $(this).parents('tr').find('td.balance').text(total);
            // balance
            bal = $(this).parents('tr').find('td.balance').text();

        }
    })    

    $(".holds").keydown(function(e){
        if(!((e.keyCode > 95 && e.keyCode < 106)
        || (e.keyCode > 47 && e.keyCode < 58) 
        || e.keyCode == 8)) {
          return false;
      }
    })

});


