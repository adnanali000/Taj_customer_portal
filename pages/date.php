<?php
include('conn.php');
include('navbar.php');

if (!isset($_SESSION['userid'])) {
  header('location: login.php');
}

if(isset($_GET['submit'])){
 
    $fromdate = htmlentities($_GET['fromdate'],ENT_QUOTES);
    $todate = htmlentities($_GET['todate'],ENT_QUOTES);

  
//     $query = "select CT.ACCOUNTNUM,DPT.NAME,CT.[PASSWORD],CT.CONFIRMPW
//                                 FROM CUSTTABLE CT
//                                 INNER JOIN DIRPARTYTABLE DPT ON CT.PARTY = DPT.RECID
//                                 where CT.ACCOUNTNUM = '".$userid."' and CT.[PASSWORD] = '".$password."' and CT.CONFIRMPW='".$password."' ";
//    $stmt = sqlsrv_query($conn, $query,array(),array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
//    $stmt ? "success" : "invalid";								 
//    //DIE(print_r(sqlsrv_errors(), true));
//    $num = sqlsrv_num_rows($stmt);
//    if($num==1){
//         session_start();
//         while($res = sqlsrv_fetch_array($stmt)){
//             $_SESSION['userid']=$res['ACCOUNTNUM'];
//             header('location: home.php');
//         }
//        //print_r($res);
//     }else{
//        echo '<div class="alert alert-danger bg-white text-center text-danger mb-1 text-large"  role="alert"><i class="fas fa-close" style="color:red;margin:5px;font-size:20px;margin-top:5px;"></i>Wrong Password</div>';
//     }
 
}


if (isset($_SESSION['userid'])) {
  $userid = $_SESSION['userid'];
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ledger Report</title>

  </head>

  <body>
    <div class="container-fluid">
    
    <form method="GET" class="form-inline">
  <div class="form-group">
    <label for="fromdate">From Date:</label>
    <input type="date" name="fromdate" class="form-control" id="fromdate">
  </div>
  <div class="form-group ml-5">
    <label for="todate">To Date:</label>
    <input type="date" name="todate" class="form-control" id="todate">
  </div>
  <button type="submit" id="sub"  name="submit" class="btn btn-secondary m-3" disabled>Submit</button>
</form>

    </div>

    <script>

        // let fromdate = document.getElementById("fromdate");
        // let toDate = document.getElementById("todate");
        // let submit = document.getElementById("sub");

        // if(fromdate.value == null && toDate.value==null){
        //     submit.disabled = true;
        // }else{
        //     submit.disabled = false;
        // }
        
        $(document).ready(function(){
            var fromdate,todate;
            $('#fromdate').change(function(){
                fromdate = $('#fromdate').val();
                
                $('#todate').change(function(){
                    todate = $('#todate').val();
                    $("#sub").prop('disabled',false);
                })
            })
           

           


        })

        
    
    </script>
  </body>

  </html>

<?php 
} //session close
?>