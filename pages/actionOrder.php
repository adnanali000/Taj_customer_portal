<?php
include('conn.php');
    if(isset($_GET['productvalue'])){

        $productcode = $_GET['productvalue'];
        $query = 
        "select IT.NAMEALIAS

        FROM INVENTTABLE IT
        
        WHERE IT.DATAAREAID = 'TGPL' AND IT.ITEMID = '".$productcode."'";
        
        $stmt = sqlsrv_query($conn, $query,array(),array("Scrollable"=>'static')) or DIE(sqlsrv_errors());

        $num = sqlsrv_num_rows($stmt);
	    if($num==1){
            while($res = sqlsrv_fetch_array($stmt)){
                echo $res['NAMEALIAS'];
            }
        }
    }
?>