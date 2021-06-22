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
<style>
    #nav2{
        display: none !important;
    }
    #status{
      /* border: 1px solid black !important; */
      width: 100% !important;
      height: 100px !important;
      padding: 0 !important;
    }
    #status a{
      font-size: 13px !important;
      /* border: 1px solid black !important; */
    } 
    
    #deliver,#invoice{
      margin-left: 28px !important;
    }
    #ship,#submit,#schedule{
      margin-left: 35px !important;
    }
  
    
</style>
<body>
    <div class="container-fluid">

    <!-- summary header  -->

    
    <section class="text-gray-600 mb-3 body-font" id="status">
  <div class="container py-3  flex flex-wrap flex-col">
    <div class="flex mx-auto flex-wrap">
      <a class="sm:px-6 py-3 w-1/2 sm:w-auto justify-center sm:justify-start border-b-2 title-font font-medium   items-center leading-none  text-indigo-500 tracking-wider rounded-t">
        <i class="fas fa-check" style="color:green;margin:5px;font-size:22px;" ></i> Submitted <p id="submit">11 Jun 2021</p>
      </a>
      <a class="sm:px-6 py-3 w-1/2 sm:w-auto justify-center sm:justify-start border-b-2 title-font font-medium   items-center leading-none  text-indigo-500 tracking-wider rounded-t">
        <i class="fas fa-check" style="color:green;margin:5px;font-size:22px;" ></i> Scheduled <p id="schedule">11 Jun 2021</p>
      </a>
      <a class="sm:px-6 py-3 w-1/2 sm:w-auto justify-center sm:justify-start bg-gray-100 border-indigo-500 border-b-2 title-font font-medium   items-center leading-none  text-indigo-500 tracking-wider rounded-t">
        <i class="fas fa-check" style="color:green;margin:5px;font-size:22px;" ></i> Shipped <p id="ship">11 Jun 2021</p>
      </a>
      <a class="sm:px-6 py-3 w-1/2 sm:w-auto justify-center sm:justify-start border-b-2 title-font font-medium   items-center leading-none  text-indigo-500 tracking-wider rounded-t">
        <i class="fas fa-close" style="color:red;margin:5px;font-size:22px;" ></i> Delivered <p id="deliver">11 Jun 2021</p>
      </a>
      <a class="sm:px-6 py-3 w-1/2 sm:w-auto justify-center sm:justify-start border-b-2 title-font font-medium   items-center leading-none  text-indigo-500 tracking-wider rounded-t">
        <i class="fas fa-close" style="color:red;margin:5px;font-size:22px;" ></i> Invoiced <p id="invoice">11 Jun 2021</p>
      </a>
    </div>
  </div>
</section>
      
        
<table class="table mt-5 table-sm mt-1 table-hover" id="customtab">
        
        <thead class="head">
          <tr class="table-bordered text-black text-center">
              <th scope="col">SO Number</th>
              <th scope="col">Packing Slip ID</th>
              <th scope="col">Scheduled Date</th>
              <th scope="col">Ship Date</th>
              <th scope="col">Submitted Date</th>
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
              ST.SHIPPINGDATEREQUESTED AS SCHEDULEDATE,

              ST.CREATEDDATETIME AS SUBMITEDDATE,CPST.ITEMID AS ITEMCODE, 
              CPST.NAME ITEMNAME,CPST.SALESUNIT AS UoM
              
              ,CPST.QTY RCVNGQTY,CJR.INVOICEID,CJR.INVOICEDATE
              
              FROM SALESTABLE ST
              
              INNER JOIN CUSTPACKINGSLIPJOUR PSJ ON ST.SALESID = PSJ.SALESID
              
              INNER JOIN CUSTPACKINGSLIPTRANS CPST ON PSJ.PACKINGSLIPID = CPST.PACKINGSLIPID

              INNER JOIN CUSTINVOICEJOUR AS CJR ON CJR.SALESID = ST.SALESID


              WHERE ST.SALESID = '".$saleid."' ";

              $stmt = sqlsrv_query($conn, $query, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
             
            //   $res = sqlsrv_fetch_array($stmt);
                
                while($res = sqlsrv_fetch_array($stmt)){
          ?>

              <tr class="text-black text-center">
              <td><?php echo $res['SALESID'];?></td>
              <td><?php echo $res['PACKINGSLIPID'];?></td>
              <td><?php echo $res['SCHEDULEDATE']->format('Y-m-d')?></td>
              <td><?php echo $res['SHIPDATE']->format('Y-m-d');?></td>
              <td><?php echo $res['SUBMITEDDATE']->format('Y-m-d')?></td>
              <td><?php echo $res['ITEMCODE'];?></td>
              <td><?php echo $res['ITEMNAME'];?></td>
              <td><?php echo $res['UoM'];?></td>
              <td><?php echo number_format($res['RCVNGQTY'],2) ;?></td>
              <td><?php echo $res['INVOICEID'];?></td>
              <td><?php echo $res['INVOICEDATE']->format('Y-m-d')?></td>

          </tr>
          <?php 
            }
            // }
          ?>
</tbody>
</table> 
    </div>

    <script>
        // removing datatables button 
        $(document).ready(function(){
          $('#customtab').DataTable({
            dom: ''
          })
        })
        


    </script>
</body>
</html>
