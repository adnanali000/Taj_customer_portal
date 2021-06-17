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
    <title>Invoiced Orders</title>

  </head>

  <body>
    <div class="container-fluid">

      <table class="table table-sm mt-1 table-hover" id="tab">

        <thead class="head">
          <tr class="table-bordered text-black text-center">
            <th scope="col">Sales Id</th>
            <th scope="col">Sales Status</th>
            <th scope="col">Invent Site Id</th>
            <th scope="col">Invent Location Id</th>
            <th scope="col">Created DateTime</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $query = "select ST.SALESID,ST.CUSTACCOUNT, ST.SALESNAME,
                    CASE WHEN ST.SALESSTATUS = 3 THEN 'INVOICED' ELSE ' ' END AS SALESSTATUS,
                    ST.INVENTSITEID,ST.INVENTLOCATIONID,
                    ST.CREATEDDATETIME FROM SALESTABLE ST WHERE ST.CUSTACCOUNT = '" . $userid . "' and ST.SALESSTATUS = 3";
          $stmt = sqlsrv_query($conn, $query, array(), array("Scrollable" => 'static')) or die(sqlsrv_errors());
          $res = sqlsrv_fetch_array($stmt);
          while ($res = sqlsrv_fetch_array($stmt)) {
          ?>

            <tr class="text-black text-center">
              <td><a href="./saleOrderDetail.php?salesid=<?php echo $res['SALESID']; ?>" target="_blank" class="text-primary"><?php echo $res['SALESID']; ?></a></td>
              <td class="text-danger"><?php echo $res['SALESSTATUS']; ?></td>
              <td><?php echo $res['INVENTSITEID']; ?></td>
              <td><?php echo $res['INVENTLOCATIONID']; ?></td>
              <td><?php echo $res['CREATEDDATETIME']->format('Y-m-d H:i:s') ?></td>

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