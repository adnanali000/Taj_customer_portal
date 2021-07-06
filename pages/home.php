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

?>


<form>
<div class="form-row">
<div class="form-group col-md-3">
    <label class="col-form-label">Customer Balance :</label>
    <input type="text" class="form-control num" value="<?= number_format( $res["Balance"],2);?>" placeholder="hello" disabled>
</div>
<div class="form-group col-md-3">
    <label class="col-form-label">Customer Credit_Limit :</label>
    <input type="text" class="form-control num" value="<?= number_format($res["Credit_Limit"],2) ;?>"  placeholder="hello" disabled>
</div>
</div>

</form>

  <div class="test"></div>
  <div class="test2"></div>
  <div class="test3"></div>
  <div class="test4"></div>


  <div class="chart">
    <div id="chartContainer" style="height: 300px;"></div>  
    <div><div id="chartContainer2" style="height: 300px;"></div>  
    <!-- <div><h1>graph 3</h1></div> -->

  </div>
    
  </div>
  
  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

  </html>

<?php } //session close
?>