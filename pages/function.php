<?php
    include("conn.php");

    function getName($id){
        global $conn;
        $query = "select DPT.NAME
								 FROM CUSTTABLE CT
								 INNER JOIN DIRPARTYTABLE DPT ON CT.PARTY = DPT.RECID
								 where CT.ACCOUNTNUM = '".$id."'";
        $stmt = sqlsrv_query($conn, $query,array(),array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
        $num = sqlsrv_num_rows($stmt);
         if($num==1){
                while($res = sqlsrv_fetch_array($stmt)){
                return $res['NAME'];
            }
                                     //print_r($res);
        }else{
           return "failed";
        
  }
                              
    }

    function getAccount($num){
        global $conn;
        $query = "select CT.ACCOUNTNUM
								 FROM CUSTTABLE CT
								 INNER JOIN DIRPARTYTABLE DPT ON CT.PARTY = DPT.RECID
								 where CT.ACCOUNTNUM = '".$num."'";
        $stmt = sqlsrv_query($conn, $query,array(),array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
        $num = sqlsrv_num_rows($stmt);
         if($num==1){
                while($res = sqlsrv_fetch_array($stmt)){
                return $res['ACCOUNTNUM'];
            }
                                     //print_r($res);
        }else{
           return "failed";
        
  }
                              
    }

?>