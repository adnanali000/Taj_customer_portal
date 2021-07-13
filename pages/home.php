<?php
include('conn.php');
include('navbar.php');

if (!isset($_SESSION['userid'])) {
  header('location: login.php');
}

if (isset($_SESSION['userid'])) {
  $userid = $_SESSION['userid'];
  // print_r($_SESSION);
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/charts.css">
    <link rel="stylesheet" href="../css/jquery.convform.css">
    <script src="../js/jquery.convform.js"></script>
<!-- chat bot  -->
  </head>
  <!-- //chart work -->
  <?php

//open
$query = "select COUNT(SALESID) AS sales FROM SALESTABLE where CUSTACCOUNT = '" . $userid . "' and SALESSTATUS=1";
$stmt = sqlsrv_query($conn, $query, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
$result = sqlsrv_fetch_array($stmt);

//invoiced
$query2 = "select COUNT(SALESID) AS invoice FROM SALESTABLE where CUSTACCOUNT = '" . $userid . "' and SALESSTATUS=3";
$stmt2 = sqlsrv_query($conn, $query2, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
$result2 = sqlsrv_fetch_array($stmt2);

//cancel
$query3 = "select COUNT(SALESID) AS cancel FROM SALESTABLE where CUSTACCOUNT = '" . $userid . "' and SALESSTATUS=4";
$stmt3 = sqlsrv_query($conn, $query3, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
$result3 = sqlsrv_fetch_array($stmt3);

//total sales table
$query4 = "select COUNT(SALESID) AS total FROM SALESTABLE where CUSTACCOUNT = '" . $userid . "' and SALESSTATUS in ('1','3','4')";
$stmt4 = sqlsrv_query($conn, $query4, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
$result4 = sqlsrv_fetch_array($stmt4);

//holdsfree
$query5 = "select SUM(HOLDFREEQTY) AS holds FROM orderedtable where ORDERCREATEDUSER = '" . $userid . "'";
$stmt5 = sqlsrv_query($conn, $query5, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
$result5 = sqlsrv_fetch_array($stmt5);

//balance
$query6 = "select SUM(BALANCE) AS balance FROM orderedtable where ORDERCREATEDUSER = '" . $userid . "'";
$stmt6 = sqlsrv_query($conn, $query6, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
$result6 = sqlsrv_fetch_array($stmt6);

//req quantity
$query7 = "select SUM(REQUIREDQUANTITY) AS quantity FROM orderedtable where ORDERCREATEDUSER = '" . $userid . "'";
$stmt7 = sqlsrv_query($conn, $query7, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
$result7 = sqlsrv_fetch_array($stmt7);

//variables
$open = $result['sales'];
$invoice = $result2['invoice'];
$cancel = $result3['cancel'];
$total = $result4['total'];
$holds = $result5['holds'];
$balance = $result6['balance'];
$quantity = $result7['quantity'];
$totalOrder = $holds+$quantity+$balance;


//percentage calculation
$openPer =  number_format(($open/$total)*100,2) ;
$invoicePer = number_format(($invoice/$total)*100,2) ;
$cancelPer = number_format(($cancel/$total)*100,2);
$holdPer = number_format(($holds/$totalOrder)*100,2);
$balancePer = number_format(($balance/$totalOrder)*100,2);
$qtyPer = number_format(($quantity/$totalOrder)*100,2);

// print_r($holds.'<br>'.$balance."<br>".$quantity."<br>".$totalOrder);


// print_r($openPer);
// print_r($invoicePer);
?>

<script>
    window.onload = function() {
  
      CanvasJS.addColorSet("redShades",
                [//colorSet Array
                  "#ED1C24",
                  "#464342",
                "#746F6D",
                // "#3CB371",
                // "#90EE90"                
                ]);
    var chart = new CanvasJS.Chart("chartContainer", {
    colorSet:"redShades",
    exportEnabled: true,
    animationEnabled: true,
    title:{
      text: "Order Detail",
      fontSize: 20,
      fontFamily:"Neutra Text",
      

      
    },
    legend:{
      cursor: "pointer",
      itemclick: explodePie,

    },
    data: [{
      type: "pie",
      showInLegend: true,
      toolTipContent: "{name}: <strong>{y}%</strong>",
      indexLabel: "{name} - {y}%",
      dataPoints: [
        { y: "<?php echo $invoicePer;?>", name: "Invoiced" },
        { y: "<?php echo $cancelPer;?>", name: "Cancelled" },
        { y: "<?php echo $openPer;?>", name: "Open Order" },

      ]
    }]
  });
  CanvasJS.addColorSet("greyShades",
                [//colorSet Array

                "#ED1C24",
                "#464342",
                "#746F6D",
                // "#3CB371",
                // "#90EE90"                
                ]);
  var chart2 = new CanvasJS.Chart("chartContainer2", {
    colorSet:"greyShades",
    exportEnabled: true,
    animationEnabled: true,
    title:{
      text: "Purchase Order",
      fontSize: 20,
      fontFamily:"Neutra Text"

    },
    legend:{
      cursor: "pointer",
      itemclick: explodePie2,
      // horizontalAlign:"right",
      // verticalAlign:"center"
    },
    data: [{
      type: "pie",
      showInLegend: true,
      toolTipContent: "{name}: <strong>{y}%</strong>",
      indexLabel: "{name} - {y}%",
      dataPoints: [
        { y: "<?php echo $qtyPer;?>", name: "Ordered Qty" },
        { y: "<?php echo $holdPer;?>", name: "Holds Free"},
        { y: "<?php echo $balancePer;?>", name: "Balance" },

      ]
    }]
  });
  
  chart.render();
  chart2.render();
  }
  
  function explodePie (e) {
    if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
      e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
    } else {
      e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
    }
    e.chart.render();
  
  }

  function explodePie2 (e) {
    if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
      e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
    } else {
      e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
    }
    e.chart2.render();
  
  }
  
  
  </script>
<!-- <script>
     window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	exportEnabled: true,
	animationEnabled: true,
	title:{
		text: "State Operating Funds"
	},
	legend:{
		cursor: "pointer",
		itemclick: explodePie
	},
	data: [{
		type: "pie",
		showInLegend: true,
		toolTipContent: "{name}: <strong>{y}%</strong>",
		indexLabel: "{name} - {y}%",
		dataPoints: [
      { y: "<?php echo $invoicePer;?>", name: "Invoiced" },
      { y: "<?php echo $cancelPer;?>", name: "Cancelled" },
      { y: "<?php echo $openPer;?>", name: "Open Order" },
		]
	}]
});
chart.render();
}

function explodePie (e) {
	if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
		e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
	} else {
		e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
	}
	e.chart.render();

}
</script> -->




  <body>
    <div class="container-fluid">
    <?php 

$query = "select sum(ct.amountmst) as 'Balance', c.CREDITMAX as 'Credit_Limit' from custtrans as ct
inner join CUSTTABLE as c on c.ACCOUNTNUM = ct.ACCOUNTNUM
where ct.accountnum = '".$userid."'
group by c.CREDITMAX;
";
$stmt = sqlsrv_query($conn, $query, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
 $res = sqlsrv_fetch_array($stmt);
 $availableCreditLimit = $res['Credit_Limit'] - $res['Balance'];

?>


<form>
<div class="form-row mt-5">
<div class="form-group col-md-3">
    <label class="col-form-label">Customer Balance :</label>
    <input type="text" class="form-control num" value="<?= number_format( $res["Balance"],0);?>" placeholder="hello" disabled>
</div>
<div class="form-group col-md-3">
    <label class="col-form-label">Customer Credit_Limit :</label>
    <input type="text" class="form-control num" value="<?= number_format($res["Credit_Limit"],0) ;?>"  placeholder="hello" disabled>
</div>
<div class="form-group col-md-3">
    <label class="col-form-label">Available Credit_Limit :</label>
    <input type="text" class="form-control num" value="<?=number_format($availableCreditLimit,0);?>"  placeholder="hello" disabled>
</div>
<div class="form-group col-md-3">
    <!-- <label class="col-form-label">Available Credit_Limit :</label> -->
  <button type="submit" name="submit" class="btn btn-danger mt-4 ml-3 orderNow" style="margin-top: 40px !important; width: 295px !important;" id="btnorder"> <a href="./orderNow.php" class="orderBut">Order Now</a></button>
    
</div>
</div>

<?php
//HSD
//holdsfree
$query5 = "select SUM(HOLDFREEQTY) AS holds FROM orderedtable where PRODUCTCODE = '01' 
AND (ORDERCREATEDON between DATEADD(DAY, -40, GETDATE()) and GETDATE())
and ORDERCREATEDUSER = '" . $userid . "'";
$stmt5 = sqlsrv_query($conn, $query5, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
$result5 = sqlsrv_fetch_array($stmt5);

//balance
$query6 = "select SUM(BALANCE) AS balance FROM orderedtable where PRODUCTCODE = '01' 
AND (ORDERCREATEDON between DATEADD(DAY, -40, GETDATE()) and GETDATE())
and ORDERCREATEDUSER = '" . $userid . "'";
$stmt6 = sqlsrv_query($conn, $query6, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
$result6 = sqlsrv_fetch_array($stmt6);

//req quantity
$query7 = "select SUM(REQUIREDQUANTITY) AS quantity FROM orderedtable where PRODUCTCODE = '01' 
AND (ORDERCREATEDON between DATEADD(DAY, -40, GETDATE()) and GETDATE())
and  ORDERCREATEDUSER = '" . $userid . "'";
$stmt7 = sqlsrv_query($conn, $query7, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
$result7 = sqlsrv_fetch_array($stmt7);

//opened quantity
$query11 = "select SUM(SALESQTY) AS salesqty FROM salesline where itemid = '01' 
and CUSTACCOUNT = '" . $userid . "' 
AND (CREATEDDATETIME between DATEADD(DAY, -40, GETDATE()) and GETDATE())
and SALESSTATUS = 1";
$stmt11 = sqlsrv_query($conn, $query11, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
$result11 = sqlsrv_fetch_array($stmt11);

//PMG
//holdsfree
$query8 = "select SUM(HOLDFREEQTY) AS holds FROM orderedtable where PRODUCTCODE = '02' 
AND (ORDERCREATEDON between DATEADD(DAY, -40, GETDATE()) and GETDATE())
and ORDERCREATEDUSER = '" . $userid . "'";
$stmt8 = sqlsrv_query($conn, $query8, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
$result8 = sqlsrv_fetch_array($stmt8);

//balance
$query9 = "select SUM(BALANCE) AS balance FROM orderedtable where PRODUCTCODE = '02' 
AND (ORDERCREATEDON between DATEADD(DAY, -40, GETDATE()) and GETDATE())
and ORDERCREATEDUSER = '" . $userid . "'";
$stmt9 = sqlsrv_query($conn, $query9, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
$result9 = sqlsrv_fetch_array($stmt9);

//req quantity
$query10 = "select SUM(REQUIREDQUANTITY) AS quantity FROM orderedtable where PRODUCTCODE = '02' 
AND (ORDERCREATEDON between DATEADD(DAY, -40, GETDATE()) and GETDATE())
and  ORDERCREATEDUSER = '" . $userid . "'";
$stmt10 = sqlsrv_query($conn, $query10, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
$result10 = sqlsrv_fetch_array($stmt10);

//open quantity
$query12 = "select SUM(SALESQTY) AS salesqty FROM salesline where itemid = '02' 
and CUSTACCOUNT = '" . $userid . "' 
AND (CREATEDDATETIME between DATEADD(DAY, -40, GETDATE()) and GETDATE())
and SALESSTATUS = 1";
$stmt12 = sqlsrv_query($conn, $query12, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
$result12 = sqlsrv_fetch_array($stmt12);



//HSD variables
$HSDholds = $result5['holds'];
$HSDbalance = $result6['balance'];
$HSDquantity = $result7['quantity'];
$HSDopen = $result11['salesqty'];



//PMG variable
$PMGholds = $result8['holds'];
$PMGbalance = $result9['balance'];
$PMGquantity = $result10['quantity'];
$PMGopen = $result12['salesqty'];

// print_r($holds.'<br>'.$balance."<br>".$quantity."<br>".$totalOrder);


// print_r($openPer);
// print_r($invoicePer);
?>

<!-- <h2 class="mt-5">HSD</h2> -->
<!-- <div class="form-row mt-5">
<div class="form-group col-md-3">
    <label class="col-form-label"> HSD Ordered Qty :</label>
    <input type="text" class="form-control num" value="<?= number_format($HSDquantity,0) ;?>"  placeholder="hello" disabled>
</div>
<div class="form-group col-md-5">
    <label class="col-form-label">HSD Released  Qty :</label>
    <input type="text" class="form-control num" value="<?=number_format($HSDholds,0);?>"  placeholder="hello" disabled>
</div> -->
<!-- <div class="form-group col-md-3">
    <label class="col-form-label">HSD Balance Qty:</label>
    <input type="text" class="form-control num" value="<?=number_format($HSDbalance,0);?>"  placeholder="hello" disabled>
</div> -->
<!-- <div class="form-group col-md-3">
    <label class="col-form-label">HSD Opened Qty :</label>
    <input type="text" class="form-control num" value="<?= number_format( $HSDopen,0);?>" placeholder="hello" disabled>
</div> -->
</div>

<!-- <H2>PMG</H2> -->
<!-- <div class="form-row mt-5">
<div class="form-group col-md-3">
    <label class="col-form-label">PMG Ordered Qty :</label>
    <input type="text" class="form-control num" value="<?= number_format($PMGquantity,0) ;?>"  placeholder="hello" disabled>
</div>
<div class="form-group col-md-3">
    <label class="col-form-label">PMG Released  Qty :</label>
    <input type="text" class="form-control num" value="<?=number_format($PMGholds,0);?>"  placeholder="hello" disabled>
</div>
<div class="form-group col-md-3">
    <label class="col-form-label">PMG Balance Qty:</label>
    <input type="text" class="form-control num" value="<?=number_format($PMGbalance,0);?>"  placeholder="hello" disabled>
</div>
<div class="form-group col-md-3">
    <label class="col-form-label">PMG Opened Qty :</label>
    <input type="text" class="form-control num" value="<?= number_format( $PMGopen,0);?>" placeholder="hello" disabled>
</div>
</div>
</form> -->

<div class="hometable">
  <div class="hsd">
  <table class="table bg-white table-hover table-bordered">
  <thead>
    <tr>
      <th scope="col" class="tablehead">HSD</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row" width=55%>Ordered Qty</th>
      <th scope ="row" class="num"><?= number_format($HSDquantity,0) ;?></th>
    </tr>
    <tr>
      <th scope="row">Released Qty</th>
      <th class="num"><?= number_format($HSDholds,0) ;?></th>
    </tr>
    <tr>
      <th scope="row">Balance Qty</th>
      <th class="num"><?= number_format($HSDbalance,0) ;?></th>
    </tr>
    <tr>
      <th scope="row">Opened Qty</th>
      <th class="num"><?= number_format($HSDopen,0) ;?></th>
    </tr>
  </tbody>
</table>
  </div>
  <div class="pmg">
  <table class="table bg-white table-hover table-bordered">
  <thead>
    <tr>
      <th scope="col" class="tablehead">PMG</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row" width=55%>Ordered Qty</th>
      <th class="num"><?= number_format($PMGquantity,0);?></th>
    </tr>
    <tr>
      <th scope="row">Released Qty</th>
      <th class="num"><?= number_format($PMGholds,0);?></th>

    </tr>
    <tr>
      <th scope="row">Balance Qty</th>
      <th class="num"><?= number_format($PMGbalance,0);?></th>

    </tr>
    <tr>
      <th scope="row">Opened Qty</th>
      <th class="num"><?= number_format($PMGopen,0);?></th>

    </tr>
  </tbody>
</table>
  </div>
</div>


    
  </div>
  
  <script src="../js/chatbot.js"></script>
  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  <script>
//     $(document).ready(function(){
//     $('.chat-icon').click(function(event){
//       $('.chat-box').toggleClass('active');
//     })
// })
</script>
</body>

  </html>

<?php } //session close
?>