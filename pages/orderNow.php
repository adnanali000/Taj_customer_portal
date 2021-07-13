<?php

include('conn.php');
include('navbar.php');


if (!isset($_SESSION['userid'])) {
  header('location: login.php');
}

if(isset($_POST['submit'])){

  $site = htmlentities($_POST['site'],ENT_QUOTES);
  $productCode = htmlentities($_POST['ddl-productcode'],ENT_QUOTES);
  $productName = htmlentities($_POST['productname'],ENT_QUOTES);
  $quantity = htmlentities($_POST['quantity'],ENT_QUOTES);
  $litre = htmlentities($_POST['litre'],ENT_QUOTES);
  $recDate = htmlentities($_POST['recdate'],ENT_QUOTES);
  $balance = htmlentities($_POST['quantity'],ENT_QUOTES);
  //current cate
  $date = date('m/d/Y');
  // print_r($date);

  // getting id from ordered table
  $query1 = "select MAX(ORDERID) as orderid, MAX(RECID) as recid from OrderedTable";
  $stmt = sqlsrv_query($conn, $query1, array(), array("Scrollable" => 'static')) or die(sqlsrv_errors());
  $res = sqlsrv_fetch_array($stmt);
  $latestId = $res['orderid'];
  $newInsertedId = $latestId + 1;
  $UoM = "L";
  $latestrecid = $res['recid'];
  $newrecid = $latestrecid + 1;
  // print_r($newrecid);
  // echo "<pre>";
  // print_r($newInsertedId);


  $dataarea = "tgpl";
  $query = "insert INTO orderedtable 
  (OrderID,OrderCreatedOn,OrderCreatedUser,ProductCode,ProductName,RequiredQuantity,SiteName,Unit,RECID,DATAAREAID,BALANCE)
  VALUES 
  (?,?,?,?,?,?,?,?,?,?,?); select @@IDENTITY AS id; "; 
          $params = array(&$newInsertedId,&$date,&$userid,&$productCode,&$productName,&$quantity,&$site,&$UoM,&$newrecid,&$dataarea,&$balance);
          $stmt = sqlsrv_prepare($conn, $query, $params);

          if (sqlsrv_execute( $stmt ) === false) {
              echo "Row insertion failed";  
              echo "<pre>";
              die(print_r(sqlsrv_errors(), true)); 
          } 
          else{ 
            echo "<script>
                  Swal.fire({text:'Your Order has been Placed!', allowOutsideClick: false}).then(function(result){
                    if(result.value){
                      window.location.href = 'orderdetail.php'
                    }
                  });
                  </script>";
        $lastid = getlastid($newrecid);
        $prefixName = $site."-".$lastid;
        setPrefixId($prefixName,$newrecid);
      }

    


  ?>
    <!-- <div class="alert alert-success alert-sm "><i class="fas fa-check"></i> Your order has been placed</div> -->

  
  <?php



}

if ( isset($_SESSION['userid']) && isset($_SESSION['customersite']) ) {
    $userid = $_SESSION['userid'];
    $site = $_SESSION['customersite'];


?>

<!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Now</title>
    <link rel="stylesheet" href="../css/charts.css">
    <link rel="stylesheet" href="../css/jquery.convform.css">
    <script src="../js/jquery.convform.js"></script>



    <style>
    #order{
        width: 60% !important;
        margin: 0px auto;
        margin-top: 60px !important;
    }
    .btn{
        width: 110px !important;
        border-radius: 0px !important;
    }
    </style>
    <!-- <script>
     
     //      $("#site").on('keydown', function(event){
     
     // 	var key = event.charCode || event.keyCode || event.which;
     // 	var char = String.fromCharCode(event.key);
     //     var value = $(this).val();
     
     
     //     if(key === 8 || key=== 46){
     //         if(value.length == 4){
     //             event.preventDefault();
     //             return false;
     //         }
     // 	}	else {		
     // 		$("#site").append(char);
             
     // 	}
        
     // });
     
     $(document).ready(function(){
       var readOnlyLength = $('#site').val().length;
     
       $('#output').text(readOnlyLength);
       $('#site').on('keypress,keydown',function(event){
         var $field = $(this);
         $('#output').text(event.which + '-' + this.selectionStart);
         if((event.which != 37 && (event.which != 39)) 
           && ((this.selectionStart < readOnlyLength) 
           || ((this.selectionStart == readOnlyLength) && (event.which == 8)))){
             return false;
           }
       });
     })    
         
         </script> -->
<script src="../js/chatbot.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var readOnlyLength = $('#test').val().length;
        $('#output').text(readOnlyLength);

        $('#test').on('keypress, keydown', function(event) {
            var $field = $(this);
            $('#output').text(event.which + '-' + this.selectionStart);
            if ((event.which != 37 && (event.which != 39))
                && ((this.selectionStart < readOnlyLength)
                || ((this.selectionStart == readOnlyLength) && (event.which == 8)))) {
                return false;
            }

            
            
        }); 

        
    })  

</script>

<style>
/* form button  */
.btn{
  background-color: #ED1C24 !important;
}
.opt:hover{
  background-color: red !important;
}

/* dropdown menu background */

</style>
     

  </head>

  <body>
    <div class="container-fluid">
    <form class="row g-3" method="POST" id="order">
  <div class="col-md-6">
    <label for="site" class="form-label">Site Name:</label>
    <input type="text" class="form-control" autocomplete="off" value="<?=$site;?>" id="test" name="site" readonly>
  </div>
  <!-- <div class="col-md-6">
    <label for="code" class="form-label">Product Code</label>
    <input type="text" class="form-control" id="code" name="productcode" placeholder="product code" required>
  </div> -->
  <div class="form-group" style="margin-left: 10px !important;">
  <label for="code" class="form-label">Product Code:</label>
  <select class="form-control" name="ddl-productcode" id="code">
  <option disabled value="-1" selected>-- Select Product --</option>
    <option value="01" class="opt">01-HSD</option>
    <option value="02" class="opt">02-PMG</option>

  </select>
</div>

  <div class="col-md-6 mt-4">
    <label for="site" class="form-label">Product Name:</label>
    <input type="text" class="form-control" id="productname" name="productname" required readonly>
  </div>
  <div class="col-md-6 mt-4">
    <label for="code" class="form-label">Required Quantity</label>
    <input type="number" min="5000" class="form-control" autocomplete="off" id="quantity" name="quantity" placeholder="QTY" required>
  </div>

  <div class="col-md-6 mt-4">
    <label for="site" class="form-label">UoM:</label>
    <input type="text" class="form-control" id="litre" name="litre" value="Litres" required readonly>
  </div>
  <!-- <div class="col-md-6 mt-4">
    <label for="code" class="form-label">Tentative Recieve Date:</label>
    <input type="date" class="form-control" id="recdate" name="recdate" required placeholder="product code">
  </div> -->
 
 
  <div class="col-md-6 mt-4">
    <button type="submit" name="submit" class="btn btn-danger mt-4 ml-3" style="margin-top: 33px !important;width:300px !important" id="btnorder">Order Now</button>
  </div>
</form>


    </div>

  <script src="../js/actionorder.js"></script>

  </body>

  </html>

<?php 
} //session close
?>