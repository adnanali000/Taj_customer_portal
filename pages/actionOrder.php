<?php
include('conn.php');
    if(isset($_GET['productvalue'])){

        $productcode = $_GET['productvalue'];
        $query = 
        "select e.NAME

        FROM INVENTTABLE IT
        inner join ECORESPRODUCTTRANSLATION as e on e.PRODUCT = IT.PRODUCT
        
        WHERE IT.DATAAREAID = 'TGPL' AND IT.ITEMID = '".$productcode."'";
        
        $stmt = sqlsrv_query($conn, $query,array(),array("Scrollable"=>'static')) or DIE(sqlsrv_errors());

        $num = sqlsrv_num_rows($stmt);
	    if($num==1){
            while($res = sqlsrv_fetch_array($stmt)){
                echo $res['NAME'];
            }
        }
    }
?>