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
            <th scope="col">Order Prefix ID</th>
            <th scope="col">Site Name</th>
            <th scope="col">Product Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Tentaive Date</th>
            <th scope="col">Created Date</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $query = "select ORDERPREFIXID,SITENAME,PRODUCTNAME,REQUIREDQUANTITY,TENTATIVERECDATE,ORDERCREATEDON 
          from orderedtable where ORDERCREATEDUSER='".$userid."' ORDER BY ORDERCREATEDON DESC";
          $stmt = sqlsrv_query($conn, $query, array(), array("Scrollable" => 'static')) or die(sqlsrv_errors());
          //$res = sqlsrv_fetch_array($stmt);
          
          while ($res = sqlsrv_fetch_array($stmt)) {
          ?>

            <tr class="text-black text-center">
              <td><?php echo $res['ORDERPREFIXID']; ?></td>
              <td><?php echo $res['SITENAME']; ?></td>
              <td><?php echo $res['PRODUCTNAME']; ?></td>
              <td><?php echo $res['REQUIREDQUANTITY']; ?></td>
              <td><?php echo $res['TENTATIVERECDATE']->format('Y-m-d') ?></td>
              <td><?php echo $res['ORDERCREATEDON']->format('Y-m-d') ?></td>
              
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>

  </body>

  </html>

<?php } //session close
?>