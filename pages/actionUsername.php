<?php
include('conn.php');
    if(isset($_GET['idvalue'])){

        $id = $_GET['idvalue'];
        $query = 
        "select DPT.NAME
        FROM CUSTTABLE CT
        INNER JOIN DIRPARTYTABLE DPT ON CT.PARTY = DPT.RECID where CT.ACCOUNTNUM= '".$id."'  ";
        
        $stmt = sqlsrv_query($conn, $query,array(),array("Scrollable"=>'static')) or DIE(sqlsrv_errors());

        $num = sqlsrv_num_rows($stmt);
	    if($num==1){
            while($res = sqlsrv_fetch_array($stmt)){
                echo $res['NAME'];
            }
        }
    }
?>