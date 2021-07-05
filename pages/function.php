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


    //admin name

    
//     function getadmin($name){
//         global $conn;
//         $query2 = "select CT.ACCOUNTNUM
// 								 FROM CUSTTABLE CT
// 								 INNER JOIN DIRPARTYTABLE DPT ON CT.PARTY = DPT.RECID
// 								 where CT.ACCOUNTNUM = '".$num."'";
//         $stmt = sqlsrv_query($conn, $query,array(),array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
//         $num = sqlsrv_num_rows($stmt);
//          if($num==1){
//                 while($res = sqlsrv_fetch_array($stmt)){
//                 return $res['ACCOUNTNUM'];
//             }
//                                      //print_r($res);
//         }else{
//            return "failed";
        
//   }
                              
//     }

    //last index id


    function getlastid($recid){
        global $conn;
        $query = "select MAX(ORDERID) as orderid from orderedtable where recid = '".$recid."'";
        $stmt = sqlsrv_query($conn, $query,array(),array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
        $num = sqlsrv_num_rows($stmt);
        if($num==1){
        while($res = sqlsrv_fetch_array($stmt)){
        return $res['orderid'];
        }
            //print_r($res);
        }else{
        return "failed";

}
    }

    function setPrefixId($prefix,$recid){
        global $conn;
        $query = "update orderedtable set orderprefixid = '".$prefix."' where recid = '".$recid."'";
        if(sqlsrv_query($conn,$query)){
            return true;
        }else{
            return false;
        }     
    
    }

    //getitemname
    function getItemName($itemId){
        global $conn;
        $query = "select IT.NAMEALIAS

        FROM INVENTTABLE IT
        inner join ECORESPRODUCTTRANSLATION as e on e.PRODUCT = IT.PRODUCT
        
        WHERE IT.DATAAREAID = 'TGPL' AND IT.ITEMID = '".$itemId."'";
        $stmt = sqlsrv_query($conn, $query,array(),array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
        $num = sqlsrv_num_rows($stmt);
        if($num==1){
            while($res = sqlsrv_fetch_array($stmt)){
                return $res['NAMEALIAS'];
            }
        }else{
            return "failed";
        }       
    }

    //TL Dropdown
    function tlData(){
        global $conn;
        $query = "sELECT CARRIERCODE FROM TMSCARRIER WHERE DATAAREAID = 'TGPL' AND ACTIVE = 1";
        $stmt = sqlsrv_query($conn, $query,array(),array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
        while($res=sqlsrv_fetch_array($stmt)){
            echo '<option value="'.$res["CARRIERCODE"].'">'.$res["CARRIERCODE"].'</option>';
        }
    }   


