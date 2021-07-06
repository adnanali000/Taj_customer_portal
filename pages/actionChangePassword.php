<?php
    include('conn.php');
    session_start();
    if(isset($_GET['oldpass'])){
        
        $password = $_GET['oldpass'];
        $userid = $_SESSION['userid'];
        $query = "select CT.ACCOUNTNUM,CT.[PASSWORD]
        FROM CUSTTABLE CT
        where CT.ACCOUNTNUM = '".$userid."' and CT.[PASSWORD] = '".$password."' and CT.CONFIRMPW='".$password."' ";
        
        $stmt = sqlsrv_query($conn, $query,array(),array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
        $response = array();
        $num = sqlsrv_num_rows($stmt);
	    if($num==1){
            while($res = sqlsrv_fetch_array($stmt)){
                $response['message'] = "success";
                $response['userid'] = $res['ACCOUNTNUM'];
                $response['password'] = $res['PASSWORD'];
            }
        }else{
            $response['message'] = "Failed";
            $response['sess'] = $userid;

    }

    echo json_encode($response);
}

?>