<?php
include('conn.php');
include('navbar.php');

if (!isset($_SESSION['userid'])) {
  header('location: login.php');
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
    <title>Order Detail</title>

  </head>

  <body>
    <div class="container-fluid">
      <table class="table table-sm mt-1 table-hover" id="tab">

        <thead class="head">
          <tr class="table-bordered text-black text-center">
            <th scope="col">ID</th>
            <th scope="col">Order</th>
            <th scope="col">Site Name</th>
            <th scope="col">Product Code</th>
            <th scope="col">Product Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Released</th>
            <th scope="col">Balance</th>
            <th scope="col">Tank Lorry</th>
            <th scope="col">Tentative Rec Date</th>
            <th scope="col">Created Date</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $query = "select ORDERID,ORDERPREFIXID,SITENAME,COALESCE(CARRIERCODE,'N/A') as CARRIERCODE,
          PRODUCTCODE,HOLDFREEQTY,BALANCE,
          PRODUCTNAME,REQUIREDQUANTITY,TENTATIVERECDATE,ORDERCREATEDON 
          from orderedtable where ORDERCREATEDUSER='".$userid."' ORDER BY ORDERID DESC";
          $stmt = sqlsrv_query($conn, $query, array(), array("Scrollable" => 'static')) or die(sqlsrv_errors());
          //$res = sqlsrv_fetch_array($stmt);
          
          while ($res = sqlsrv_fetch_array($stmt)) {
          ?>

            <tr class="text-black text-center">
              <td><?php echo $res['ORDERID']; ?></td>
              <td><?php echo $res['ORDERPREFIXID']; ?></td>
              <td><?php echo $res['SITENAME']; ?></td>
              <td><?php echo getItemName($res['PRODUCTCODE']); ?></td>
              <td><?php echo $res['PRODUCTNAME']; ?></td>
              <td class="num"><?php echo $res['REQUIREDQUANTITY']; ?></td>
              <td class="num"><?php echo $res['HOLDFREEQTY']; ?></td>
              <td class="num"><?php echo $res['BALANCE'];?></td>
              <td class="num"><?php echo $res['CARRIERCODE'];?></td>
              <td class="num"><?php echo $res['TENTATIVERECDATE']->format('Y-m-d') ?></td>
              <td class="num"><?php echo $res['ORDERCREATEDON']->format('Y-m-d') ?></td>
              
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>

    <script src="text/javscript">
  
        // $(document).ready(function(){
        //   $("#tab11").DataTable()
        // })
  
  </script>
  </body>

  </html>

<?php } //session close
?>