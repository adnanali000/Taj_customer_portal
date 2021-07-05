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
    <title>Purchase Order Detail</title>
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
<?php
// $query = "select distinct ST.SALESID,PSJ.PACKINGSLIPID,PSJ.DELIVERYDATE AS SHIPDATE,
// ST.SHIPPINGDATEREQUESTED AS SCHEDULEDATE,

// ST.CREATEDDATETIME AS SUBMITEDDATE,CPST.ITEMID AS ITEMCODE, 
// CPST.NAME ITEMNAME,upper(CPST.SALESUNIT) AS UoM

// ,CPST.QTY RCVNGQTY,CJR.INVOICEID,CJR.INVOICEDATE

// FROM SALESTABLE ST

// left JOIN CUSTPACKINGSLIPJOUR PSJ ON ST.SALESID = PSJ.SALESID

// left JOIN CUSTPACKINGSLIPTRANS CPST ON PSJ.PACKINGSLIPID = CPST.PACKINGSLIPID

// left JOIN CUSTINVOICEJOUR AS CJR ON CJR.SALESID = ST.SALESID

// WHERE ST.SALESID = '".$saleid."' ";

$query = "select ST.SALESID,PSJ.PACKINGSLIPID,PSJ.DELIVERYDATE AS SHIPDATE,

ST.SHIPPINGDATEREQUESTED AS SCHEDULEDATE,

ST.CREATEDDATETIME AS SUBMITEDDATE,

CPST.ITEMID AS ITEMCODE,PSJ.PARMID,

CPST.NAME ITEMNAME,upper(CPST.SALESUNIT) AS UoM

,CPST.QTY RCVNGQTY

,CJR.INVOICEID,CJR.INVOICEDATE,SL.ITEMID,SL.NAME,UPPER(SL.SALESUNIT) AS UoM,SL.QTYORDERED

FROM SALESTABLE ST

INNER JOIN SALESLINE SL ON ST.SALESID = SL.SALESID

LEFT JOIN CUSTPACKINGSLIPJOUR PSJ ON ST.SALESID = PSJ.SALESID

LEFT JOIN CUSTPACKINGSLIPTRANS CPST ON PSJ.PACKINGSLIPID = CPST.PACKINGSLIPID

LEFT JOIN CUSTINVOICEJOUR AS CJR ON CJR.SALESID = ST.SALESID

WHERE ST.SALESID = '".$saleid."'";

//$res = sqlsrv_fetch_array($stmt);
$stmt = sqlsrv_query($conn, $query, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
$res = sqlsrv_fetch_array($stmt);
// while($res = sqlsrv_fetch_array($stmt))
// {

  // echo "<pre>";
    // print_r($res);

?>

<section class="text-gray-600 mb-3 body-font" id="status">
<div class="container py-3  flex flex-wrap flex-col">
<div class="flex mx-auto flex-wrap">
  <a class="sm:px-6 py-3 w-1/2 sm:w-auto justify-center sm:justify-start border-b-2 title-font font-medium items-center leading-none  text-indigo-500 tracking-wider rounded-t" id="bgsubmit">
    <i class="fas fa-check" style="color:green;margin:5px;font-size:22px;" id="sub"></i> Submitted <p id="submit"><?php echo $res['SUBMITEDDATE']->format('d-m-Y')?></p>
  </a>
  <a class="sm:px-6 py-3 w-1/2 sm:w-auto justify-center sm:justify-start border-b-2 title-font font-medium   items-center leading-none  text-indigo-500 tracking-wider rounded-t" id="bgschedule">
    <i class="fas fa-check" style="color:green;margin:5px;font-size:22px;" id="sch"></i> Scheduled <p id="schedule"><?php echo $res['SCHEDULEDATE']->format('d-m-Y')?></p>
  </a>
  <a class="sm:px-6 py-3 w-1/2 sm:w-auto justify-center sm:justify-start  border-b-2 title-font font-medium   items-center leading-none  text-indigo-500 tracking-wider rounded-t" id="bgship">
    <i class="fas fa-check" style="color:green;margin:5px;font-size:22px;" id="shi"></i> Shipped <p id="ship"><?php echo $res['SHIPDATE']->format('d-m-Y');?></p>
  </a>
  <a class="sm:px-6 py-3 w-1/2 sm:w-auto justify-center sm:justify-start border-b-2 title-font font-medium   items-center leading-none  text-indigo-500 tracking-wider rounded-t" id="bgdeliver">
    <i class="fas fa-check" style="color:green;margin:5px;font-size:22px;" id="del"></i> Delivered <p id="deliver"></p>
  </a>
  <a class="sm:px-6 py-3 w-1/2 sm:w-auto justify-center sm:justify-start border-b-2 title-font font-medium   items-center leading-none  text-indigo-500 tracking-wider rounded-t" id="bginvoice">
    <i class="fas fa-close" style="color:red;margin:5px;font-size:22px;" id="inv"></i> Invoiced <p id="invoice"><?php echo $res['INVOICEDATE']->format('d-m-Y')?></p>
  </a>
</div>
</div>
</section>


<table class="table mt-5 table-sm mt-1 table-hover" id="customtab">
    
    <thead class="head">
      <tr class="table-bordered text-black text-center">
          <th scope="col">PO Number</th>
          <th scope="col">Packing Slip ID</th>
          <th scope="col">Item Code</th>
          <th scope="col">Item Name</th>
          <th scope="col">UoM</th>
          <th scope="col">Recieving Quantity</th>
          <th scope="col">Invoice ID</th>

      </tr>
    </thead>
    <tbody>
      <?php
      // $query2 = "select ST.SALESID,PSJ.PACKINGSLIPID,PSJ.DELIVERYDATE AS SHIPDATE,
      // ST.SHIPPINGDATEREQUESTED AS SCHEDULEDATE,
      
      // ST.CREATEDDATETIME AS SUBMITEDDATE,CPST.ITEMID AS ITEMCODE, 
      // CPST.NAME ITEMNAME,upper(CPST.SALESUNIT) AS UoM
      
      // ,CPST.QTY RCVNGQTY,CJR.INVOICEID,CJR.INVOICEDATE
      
      // FROM SALESTABLE ST
      
      // left JOIN CUSTPACKINGSLIPJOUR PSJ ON ST.SALESID = PSJ.SALESID
      
      // left JOIN CUSTPACKINGSLIPTRANS CPST ON PSJ.PACKINGSLIPID = CPST.PACKINGSLIPID
      
      // left JOIN CUSTINVOICEJOUR AS CJR ON CJR.SALESID = ST.SALESID
      
      // WHERE ST.SALESID = '".$saleid."' ";

      $query2 = "select ST.SALESID, PSJ.PACKINGSLIPID,PSJ.DELIVERYDATE AS SHIPDATE,

      ST.SHIPPINGDATEREQUESTED AS SCHEDULEDATE,
      
      ST.CREATEDDATETIME AS SUBMITEDDATE,
      
      CPST.ITEMID AS ITEMCODE,PSJ.PARMID,
      
      CPST.NAME ITEMNAME,upper(CPST.SALESUNIT) AS UoM
      
      ,CPST.QTY RCVNGQTY
      
      ,CJR.INVOICEID,CJR.INVOICEDATE,SL.ITEMID as ITEMID,SL.NAME as NAME,UPPER(SL.SALESUNIT) AS UoM2,
      SL.QTYORDERED as ORDEREDQTY
      
      FROM SALESTABLE ST
      
      INNER JOIN SALESLINE SL ON ST.SALESID = SL.SALESID
      
      LEFT JOIN CUSTPACKINGSLIPJOUR PSJ ON ST.SALESID = PSJ.SALESID
      
      LEFT JOIN CUSTPACKINGSLIPTRANS CPST ON PSJ.PACKINGSLIPID = CPST.PACKINGSLIPID
      
      LEFT JOIN CUSTINVOICEJOUR AS CJR ON CJR.SALESID = ST.SALESID
      
      WHERE ST.SALESID = '".$saleid."'";
      
      //$res = sqlsrv_fetch_array($stmt);
      $stmt2 = sqlsrv_query($conn, $query2, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
          
        while($result = sqlsrv_fetch_array($stmt2)){
            
      
      ?>

              <tr class="text-black text-center">
              <td class="num"><?php echo $result['SALESID'];?></td>
              <td class="num"><?php echo $result['PACKINGSLIPID'];?></td>
              <td><?php echo $result['ITEMID'];?></td>
              <td><?php echo $result['NAME'];?></td>
              <td><?php echo $result['UoM2'];?></td>
              <td class="num"><?php echo number_format($result['ORDEREDQTY'],2) ;?></td>
              <td class="num"><?php echo $result['INVOICEID'];?></td>

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

        //date summary work

        let submit = document.getElementById('submit').innerText;
        let schedule = document.getElementById('schedule').innerText;
        let ship = document.getElementById('ship').innerText;
        let invoice = document.getElementById('invoice').innerText;
        let deliver = document.getElementById('deliver').innerText;


        if(submit){
          document.getElementById('sub').className = "fas fa-check";
          document.getElementById('sub').style.color = "green";
        }else{
          document.getElementById('sub').className = "fas fa-close";
          document.getElementById('sub').style.color = "red";
        }
        if(schedule){
          document.getElementById('sch').className = "fas fa-check";
          document.getElementById('sch').style.color = "green";
        }else{
          document.getElementById('sch').className = "fas fa-close";
          document.getElementById('sch').style.color = "red";
        }
        if(ship){
          document.getElementById('shi').className = "fas fa-check";
          document.getElementById('shi').style.color = "green";
        }else{
          document.getElementById('shi').className = "fas fa-close";
          document.getElementById('shi').style.color = "red";
        }
        if(deliver){
          document.getElementById('del').className = "fas fa-check";
          document.getElementById('del').style.color = "green";
        }else{
          document.getElementById('del').className = "fas fa-close";
          document.getElementById('del').style.color = "red";
        }
        if(invoice){
          document.getElementById('inv').className = "fas fa-check";
          document.getElementById('inv').style.color = "green";
        }else{
          document.getElementById('inv').className = "fas fa-close";
          document.getElementById('inv').style.color = "red";
        }
       
        
        // summary background color
         
        if(invoice){
          $('#bginvoice').addClass('bg-gray-100 border-indigo-500');
        }else if(deliver){
          $('#bgdeliver').addClass('bg-gray-100 border-indigo-500'); 
        }else if(ship){
          $('#bgship').addClass('bg-gray-100 border-indigo-500');
        }else if(schedule){
          $('#bgschedule').addClass('bg-gray-100 border-indigo-500');
        }else if(submit){
          $('#bgsubmit').addClass('bg-gray-100 border-indigo-500');
        }

    </script>
</body>
</html>
