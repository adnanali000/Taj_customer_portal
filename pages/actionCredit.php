<?php
session_start();
include('conn.php');
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];

    if( isset($_GET['credit'])){

        $custCredit = htmlentities($_GET['credit'],ENT_QUOTES);
        global $conn;
        $query2 = "select sum(ct.amountmst) as 'Balance', c.CREDITMAX as 'Credit_Limit' from custtrans as ct
        inner join CUSTTABLE as c on c.ACCOUNTNUM = ct.ACCOUNTNUM
        where ct.accountnum = '".$custCredit."'
        group by c.CREDITMAX;
        ";
        $stmt2 = sqlsrv_query($conn, $query2, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
        $res2 = sqlsrv_fetch_array($stmt2);
        $response = array();
        if($stmt2){
            $response['status'] = 'success';
            $response['balance'] = number_format($res2['Balance'],2);
            $response['credit'] = number_format($res2['Credit_Limit'],2);

        }else{
            $response['status'] = 'failed';
            $response['message'] = 'failed';
        }

        echo json_encode($response);
    }
}
   ?>


