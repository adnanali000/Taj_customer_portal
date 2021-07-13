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
    <title>Open Order</title>
    <link rel="stylesheet" href="../css/charts.css">
    <link rel="stylesheet" href="../css/jquery.convform.css">
    <script src="../js/jquery.convform.js"></script>

  </head>

  <body>
    <div class="container-fluid">
      <table class="table table-sm mt-1 table-hover" id="tab">

        <thead class="head">
          <tr class="table-bordered text-black text-center">
            <th scope="col">PO Number</th>
            <th scope="col">PO Status</th>
            <th scope="col">Site</th>
            <th scope="col">Warehouse</th>
            <th scope="col">Created Date</th>
          </tr>
        </thead>
        <tbody>
          <?php

          // $query = "select ST.SALESID,ST.CUSTACCOUNT, ST.SALESNAME,ST.SALESSTATUS,ST.INVENTSITEID,ST.INVENTLOCATIONID,
          //           ST.CREATEDDATETIME FROM SALESTABLE ST 
          //           WHERE ST.CUSTACCOUNT = '".$userid."' 
          //           and st.dataareaid='tgpl' and ST.SALESSTATUS = 1";

          $query = "select ST.SALESID,ST.CUSTACCOUNT, ST.SALESNAME,
          CASE WHEN ST.SALESSTATUS = 1 THEN 'Opened' ELSE ' ' END AS SALESSTATUS,
          ST.INVENTSITEID,ST.INVENTLOCATIONID,
          ST.CREATEDDATETIME FROM SALESTABLE ST WHERE 
          ST.CUSTACCOUNT = '" . $userid . "' and ST.SALESSTATUS = 1 ORDER BY CREATEDDATETIME DESC";
          $stmt = sqlsrv_query($conn, $query, array(), array("Scrollable" => 'static')) or die(sqlsrv_errors());
          //$res = sqlsrv_fetch_array($stmt);
          while ($res = sqlsrv_fetch_array($stmt)) {
          ?>

            <tr class="text-black text-center">
              <td><a href="./openorderdetail.php?salesid=<?php echo $res['SALESID']; ?>" target="_blank" class="text-primary"><?php echo $res['SALESID']; ?></a></td>
              <td class="text-danger"><?php echo $res['SALESSTATUS']; ?></td>
              <td><?php echo $res['INVENTSITEID']; ?></td>
              <td><?php echo $res['INVENTLOCATIONID']; ?></td>
              <td><?php echo $res['CREATEDDATETIME']->format('Y-m-d') ?></td>

            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>


  <script src="../js/chatbot.js"></script>

  </body>

  </html>

<?php } //session close
?>