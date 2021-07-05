<?php
session_start();
include('conn.php');
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];

    if( isset($_GET['data1']) && isset($_GET['bal']) && isset($_GET['prefix']) && isset($_GET['tl']) ){

        $hf = htmlentities($_GET['data1'],ENT_QUOTES);
        $bl = htmlentities($_GET['bal'],ENT_QUOTES);
        $pre = htmlentities($_GET['prefix'],ENT_QUOTES);
        $tl = htmlentities($_GET['tl'],ENT_QUOTES);
        
        $query = "update orderedtable set BALANCE = '".$bl."',
         HOLDFREEQTY = '".$hf."', CARRIERCODE = '".$tl."',APPROVEDDATE = GETDATE(), APPROVEDBY = '".$userid."', APPROVEDSTATUS = 1
        where ORDERPREFIXID = '".$pre."';";
        
        $stmt = sqlsrv_query($conn, $query,array(),array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
        $response = array();
        if($stmt){
            $response['status'] = 'success';
            $response['message'] = 'record updated';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'failed';
        }

        echo json_encode($response);







        // $num = sqlsrv_num_rows($stmt);
	    // if($num==1){
        //     while($res = sqlsrv_fetch_array($stmt)){
        //         echo $res['NAME'];
        //     }
        // }
    }

}
//APPROVEDDATE,APPROVEDBY,HOLDFREEQTY,BALANCE,APPROVEDSTATUS

?>


