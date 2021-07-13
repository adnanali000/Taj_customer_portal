<?php
error_reporting(1);
include('conn.php');
include('function.php');
session_start();


if (!isset($_SESSION['userid'])) {
  header('location: login.php');
}

if($_SESSION['userRole'] == 1){
  // session_destroy();
  header("location: admin.php");
}

// if(isset($_SESSION['userRole']) == 1 ){
//   header("location: admin.php");
// }

if (isset($_SESSION['userid']) && $_SESSION['userRole'] == 0 ) {
  $userid = $_SESSION['userid'];
  // header('location:home.php');
  // print_r($_SESSION);

  if (isset($_SESSION['title'])) {
    $title = $_SESSION['title'];
  }


  //ledger report php
  if(isset($_POST['report'])){
    print_r($_POST);
  }


?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/home.css">

    <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
    <link rel="manifest" href="../site.webmanifest">
    <link rel="stylesheet" href="../css/jquery.convform.css">
    <script src="../js/jquery.convform.js"></script>
    <link rel="stylesheet" href="../assets/fontawesome-free-5.15.3-web/css/all.css">
    <!-- <link rel="stylesheet" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="../assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/DataTables2/Buttons-1.7.1/css/buttons.bootstrap4.css">
    <link rel="stylesheet" href="../assets/DataTables2/Buttons-1.7.1/css/buttons.dataTables.css">
    <link rel="stylesheet" href="../assets/DataTables2/DataTables-1.10.25/css/jquery.dataTables.min.css">
	<link href="http://fonts.cdnfonts.com/css/neutra-text-alt" rel="stylesheet">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <!-- <link rel="stylesheet" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css"> -->
    <!-- <link rel="stylesheet" href="../assets/font-awesome-4.7.0/css/font-awesome.css"> -->



  </head>

  <style>
    #ledger:hover{
      border-bottom: 1px solid red;
    }
    #ledger:focus,#ledger:active {
   outline: none !important;
   box-shadow: none;
}

  </style>

  <body>
                                                <!-- navbar -->
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="./home.php">
          <img src="../icon//login.png" alt="" class="d-inline-block">
          <span class="title mt-3"></span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mr-2">
            <li class="nav-item active">
              <a class="nav-link mt-1" href="#" id="a" style="cursor:text"><?= getName($userid) ?> <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-black" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="user">
                  <i class="fas fa-cog fa-1x" style='color:lightgray'></i>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#" style="cursor:text"><i class="fas fa-angle-right" style='font-size:16px;color:red'></i><?= getAccount($userid) ?></a>
                <a class="dropdown-item" href="./changepassword.php"><i class="fas fa-angle-right" style='font-size:16px;color:red'></i>Change Password</a>
                <a class="dropdown-item" href="./logout.php"><i class="fas fa-angle-right" style='font-size:16px;color:red'></i>Logout</a>
          </ul>

        </div>
      </nav>

                                            <!-- second nav  -->
    <?php 

$query = "select sum(ct.amountmst) as 'Balance', c.CREDITMAX as 'Credit_Limit' from custtrans as ct
inner join CUSTTABLE as c on c.ACCOUNTNUM = ct.ACCOUNTNUM
where ct.accountnum = '".$userid."'
group by c.CREDITMAX;
";
        $stmt = sqlsrv_query($conn, $query, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
        $res = sqlsrv_fetch_array($stmt);
         $availableCreditLimit = $res['Credit_Limit'] - $res['Balance'];

        // print_r(number_format($res['Balance'],2));
     ?>


      <nav class="navbar  mt-2 border-bottom-0 mb-3 navbar-expand-lg navbar-light bg-white" id="nav2">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
          <li class="nav-item dropdown">
              <a class="nav-link ml-1 dropdown-toggle text-black" href="./home.php" id="navbarDropdown" role="button" >
                Home
              </a>
              <!-- <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="http://192.168.0.44/ReportServer/Pages/ReportViewer.aspx?%2fAXReports%2fpartycustomerledgernew&rs:Command=Render&GC=<?=$_SESSION['userid'];?>" target="_blank"><i class="fas fa-angle-right" style='font-size:16px;color:red'></i>Ledger Report</a>
              </div> -->
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle ml-2" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Order Details
              </a>
              <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="./allOrder.php"><i class="fas fa-angle-right" style='font-size:16px;color:red;'></i> All Orders</a>
                <a class="dropdown-item" href="./openOrder.php"><i class="fas fa-angle-right" style='font-size:16px;color:red;'></i>Open Orders</a>
                <a class="dropdown-item" href="./invoicedOrder.php"><i class="fas fa-angle-right" style='font-size:16px;color:red;'></i>Invoiced Orders</a>
                <a class="dropdown-item" href="./orderNow.php"><i class="fas fa-angle-right" style='font-size:16px;color:red;'></i>Order Now</a>
                <a class="dropdown-item" href="./orderdetail.php"><i class="fas fa-angle-right" style='font-size:16px;color:red;'></i>Purchase Order</a>

              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link ml-1 dropdown-toggle text-black" href="./orderNow.php" id="navbarDropdown" role="button" >
                Order Now
              </a>
            </li>
            <li class="nav-item dropdown">
              
            <?php

// for from date param : [ should be current date - 30 days ]

$fromDate = date('Y-m-d', strtotime('-30 days'));



// for to date param : [ current date ]

$toDate = date('Y-m-d'); // [Format : month-date-Year]

// print_r($fromDate."<br/>".$toDate);

?>



<form id="LedgerReport" action="http://192.168.0.44/ReportServer/Pages/ReportViewer.aspx?%2fAXReports%2fpartycustomerledgernew" method="POST" target="_blank">

<input type="hidden" name="rs:Command" value="Render" />

<input type="hidden" name="rc:Parameters" value="false" />  <!-- Hide report parameters -->                

<input type="hidden" name="FrmDt" value="<?= $fromDate;?>" /> <!-- Parameter From Date -->

<input type="hidden" name="ToDt" value="<?= $toDate;?>" /> <!-- Parameter To Date -->

<input type="hidden" name="GC" value="<?=$_SESSION['userid'];?>" /> <!-- Parameter GC -->

<button type="submit" class="nav-link ml-1 text-black" id="ledger">Ledger Reports</button>

</form>  
             
            
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link ml-1 dropdown-toggle text-black" href="./customertransaction.php"  id="navbarDropdown" role="button">
                Customer Transaction
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link ml-1 dropdown-toggle text-black"  id="balance"  target="_blank" id="navbarDropdown" role="button">
                Customer Balance
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link ml-1 dropdown-toggle text-black"  id="balance"  target="_blank" id="navbarDropdown" role="button">
                News
              </a>
            </li>
          </ul>
        </div>
      </nav>
      



      <!-- chat bot  -->

<div class="chat-icon">
  <i class="fas fa-comments" aria-hidden="true"> </i>
</div>

<!-- chat box  -->
<div class="chat-box">
<div class="conv-form-wrapper">
  <form action="" method="GET" class="hidden">
  <select name="category" data-conv-question="May I help you?">
	<option value="hsd">HSD ?</option>
	<option value="pmg">PMG ?</option>
</select>
<div data-conv-fork="category">
	<div data-conv-case="hsd">
	 	<input type="text" name="site" data-conv-question="Tell me your site Name.">
	</div>
  <div data-conv-case="pmg">
	 	<input type="text" name="site" data-conv-question="Tell me your site Name.">
	</div>
</div>
<input type="text" name="name" data-conv-question="Tell me your Name.">
<input data-conv-question="Type in your e-mail" data-pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" id="email" type="email" name="email" required placeholder="What's your e-mail?">
<input type="text" name="sitename" data-conv-question="Write your complain.">
<select data-conv-question="Confirm ?">
	<option value="confirm">Confirm</option>
</select>  
<input type="text" name="name" data-conv-question="Thankyou.">


</form>
</div>
</div>


















</div>

    <script src="../assets/js"></script>
    <script src="../js/chatbot.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="../assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <!-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script> -->
    <script src="../assets/DataTables2/Buttons-1.7.1/js/buttons.bootstrap4.js"></script>
    <script src="../assets/DataTables2/Buttons-1.7.1/js/dataTables.buttons.js"></script>
    <script src="../assets/DataTables2/Buttons-1.7.1/js/buttons.dataTables.js"></script>
    <script src="../assets/fontawesome-free-5.15.3-web/js/all.js"></script>
    <script src="../assets/DataTables2/DataTables-1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      $(document).ready(function() {
        $("#tab").DataTable({
          language: {
            search: "",
            searchPlaceholder: "Search...",
            lengthMenu:     "Show _MENU_ Entries"
          },
          "ordering": false
          
        });
      
      
      
      
      })

    
      let balance = document.getElementById('balance');
      balance.addEventListener("click",function(){ 
          Swal.fire({html:'Balance:  <?= number_format( $res["Balance"],0);?> <br><br>  Credit Limit: <?= number_format( $res["Credit_Limit"],0);?> <br><br>  Available Credit Limit: <?= number_format( $availableCreditLimit,0);?>',
                    confirmButtonText:'Close'});
      })
      
        
     
        
      
  
    </script>
  </body>

  </html>
<?php } ?>