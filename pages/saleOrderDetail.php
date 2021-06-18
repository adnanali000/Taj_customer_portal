<?php
include('conn.php');
include('navbar.php');

if( isset($_GET['salesid'])){
    $saleid = $_GET['salesid'];
}
// if( isset($_SESSION['title']))
// {
//   $title = $_SESSION['title'];
// }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Order Detail</title>
</head>
<body>
    <div class="container-fluid">
<table class="table table-sm mt-1 table-hover" id="tab">
        
        <thead class="head">
          <tr class="table-bordered text-black text-center">
              <th scope="col">SO Number</th>
              <th scope="col">Packing Slip ID</th>
              <th scope="col">Ship Date</th>
              <th scope="col">Recieving Date</th>
              <th scope="col">Item Code</th>
              <th scope="col">Item Name</th>
              <th scope="col">UoM</th>
              <th scope="col">Recieving Quantity</th>
              <th scope="col">Invoice ID</th>
              <th scope="col">Invoice Date</th>

          </tr>
        </thead>
        <tbody>
        <?php

              $query = "select ST.SALESID,PSJ.PACKINGSLIPID,PSJ.DELIVERYDATE AS SHIPDATE,

              PSJ.CREATEDDATETIME AS RECEIVINGDATE,CPST.ITEMID AS ITEMCODE, CPST.NAME as ITEMNAME,upper(CPST.SALESUNIT) AS UoM
              
              ,CPST.QTY RCVNGQTY,CJR.INVOICEDATE,CJR.INVOICEID
              
              FROM SALESTABLE ST
              
              INNER JOIN CUSTPACKINGSLIPJOUR PSJ ON ST.SALESID = PSJ.SALESID
              
              INNER JOIN CUSTPACKINGSLIPTRANS CPST ON PSJ.PACKINGSLIPID = CPST.PACKINGSLIPID
              
              INNER JOIN CUSTINVOICEJOUR AS CJR ON ST.SALESID = CJR.SALESID

              WHERE ST.SALESID = '".$saleid."' ";

              $stmt = sqlsrv_query($conn, $query, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
             
            //   $res = sqlsrv_fetch_array($stmt);
                
                while($res = sqlsrv_fetch_array($stmt)){
          ?>

              <tr class="text-black text-center">
              <td><?php echo $res['SALESID'];?></td>
              <td><?php echo $res['PACKINGSLIPID'];?></td>
              <td><?php echo $res['SHIPDATE']->format('Y-m-d H:i:s');?></td>
              <td><?php echo $res['RECEIVINGDATE']->format('Y-m-d H:i:s')?></td>
              <td><?php echo $res['ITEMCODE'];?></td>
              <td><?php echo $res['ITEMNAME'];?></td>
              <td><?php echo $res['UoM'];?></td>
              <td><?php echo number_format($res['RCVNGQTY'],2) ;?></td>
              <td><?php echo $res['INVOICEID'];?></td>
              <td><?php echo $res['INVOICEDATE']->format('Y-m-d H:i:s')?></td>

          </tr>
          <?php 
            }
            // }
          ?>
</tbody>
</table> 
    </div>
</body>
</html>
