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
    <title>All Orders</title>
  </head>

  <body>
    <div class="container-fluid">
      <table class="table table-sm mt-1 table-hover" id="tab">

        <thead class="head">
          <tr class="table-bordered text-black text-center">
            <th scope="col">Purchase ID</th>
            <th scope="col">Purchase Status</th>
            <th scope="col">Invent Site ID</th>
            <th scope="col">Invent Location ID</th>
            <th scope="col">Created Date</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $query = "select ST.SALESID,ST.CUSTACCOUNT, ST.SALESNAME,
                    CASE WHEN ST.SALESSTATUS = 3 THEN 'INVOICED' WHEN ST.SALESSTATUS = 1 THEN 'OPEN ORDER' WHEN ST.SALESSTATUS = 4 THEN 'CANCELLED'  ELSE ' ' END AS 'SALESSTATUS',
                    ST.INVENTSITEID,ST.INVENTLOCATIONID,
                    ST.CREATEDDATETIME FROM SALESTABLE ST WHERE ST.CUSTACCOUNT = '" . $userid . "' AND ST.SALESSTATUS IN(1,3) ORDER BY CREATEDDATETIME DESC" ;
          $stmt = sqlsrv_query($conn, $query, array(), array("Scrollable" => 'static')) or die(sqlsrv_errors());
          $res = sqlsrv_fetch_array($stmt);
          while ($res = sqlsrv_fetch_array($stmt)) {
          ?>

            <tr class="text-black text-center">
              <td class="num">

                <?php
                $sal = $res['SALESID']; 
                $status = $res['SALESSTATUS'];
                
                  if($status == 'INVOICED'){
                      echo "<a href='./invoiceorderdetail.php?salesid=$sal' target='_blank' class='text-primary'>$sal</a>";
                  }else if( $status == 'OPEN ORDER'){
                    echo "<a href='./openorderdetail.php?salesid=$sal' target='_blank' class='text-primary'>$sal</a>";
                  }else {

                  }
                ?>
                <!-- <a href="./invoiceorderdetail.php?salesid=<?php //echo $res['SALESID']; ?>"  target="_blank" class="text-primary"><?php echo $res['SALESID']; ?></a> -->
              </td>
              <td class="text-danger"><?php echo $res['SALESSTATUS']; ?></td>
              <td><?php echo $res['INVENTSITEID']; ?></td>
              <td><?php echo $res['INVENTLOCATIONID']; ?></td>
              <td class="num"><?php echo $res['CREATEDDATETIME']->format('Y-m-d') ?></td>

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