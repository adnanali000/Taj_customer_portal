<?php
include('conn.php');
    if(isset($_GET['idvalue'])){

        $name = $_GET['idvalue'];
        $query2 = 
        "select name from USERINFO where networkalias= '".$name."' ";
        
        $stmt2 = sqlsrv_query($conn, $query2,array(),array("Scrollable"=>'static')) or DIE(sqlsrv_errors());

        $num2 = sqlsrv_num_rows($stmt2);
	    if($num2==1){
            while($res = sqlsrv_fetch_array($stmt2)){
                echo $res['name'];
            }
        }
    }
?>