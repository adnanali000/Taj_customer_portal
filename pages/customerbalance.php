<?php
   include('conn.php');
   include('navbar.php');
    
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Customer Balance</title>
 </head>
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
            <input type="text" class="form-control" value="<?= number_format( $res["Balance"],2);?>" placeholder="hello" disabled>
        </div>
        <div class="form-group col-md-3">
            <label class="col-form-label">Customer Credit_Limit :</label>
            <input type="text" class="form-control" value="<?= number_format($res["Credit_Limit"],2) ;?>"  placeholder="hello" disabled>
        </div>
    </div>
    
</form>

<table class="table table-sm mt-1 table-hover" id="tab">
        
        <thead class="head">
          <tr class="table-bordered text-black text-center">
              <th scope="col">Voucher</th>
              <th scope="col">Transaction Type</th>
              <th scope="col">Transaction Date</th>
              <th scope="col">Invoice</th>
              <th scope="col">Credit</th>
              <th scope="col">Debit</th>
              <th scope="col">Balance</th>
              <th scope="col">Currency Code</th>
          </tr>
        </thead>
        <tbody>

                <?php

                    $query = "select CT.VOUCHER,
                    CASE WHEN CT.TRANSTYPE = 2 THEN 'SALES ORDER' WHEN CT.TRANSTYPE = 15 THEN 'PAYMENT' ELSE '' END AS TRANSTYPE,CT.TRANSDATE , case when ct.invoice  = '' then 'N/A' else ct.invoice end as 'INVOICE',
                    (SELECT ABS(CCT.AMOUNTCUR) FROM CUSTTRANS CCT WHERE CCT.TRANSTYPE = 15 AND CCT.RECID = CT.RECID) AS CREDIT,
                    (SELECT ABS(CCT.AMOUNTCUR) FROM CUSTTRANS CCT WHERE CCT.TRANSTYPE = 2 AND CCT.RECID = CT.RECID) AS DEBIT,
                    (ABS(CT.AMOUNTCUR)-ABS(CT.SETTLEAMOUNTCUR)) AS BALANCE,CT.CURRENCYCODE
                    FROM CUSTTRANS CT WHERE CT.ACCOUNTNUM = '".$userid."' AND TRANSTYPE IN ('15','2')
                    ORDER BY CT.TRANSDATE DESC
                    ";
                  	$stmt = sqlsrv_query($conn, $query, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
                    $result = sqlsrv_fetch_array($stmt);
                      
                      while($result = sqlsrv_fetch_array($stmt)){
                ?>

                <tr class="text-black text-center">
                    <td><?php echo $result['VOUCHER'];?></td>
                    <td><?php echo $result['TRANSTYPE'];?></td>
                    <td><?php echo $result['TRANSDATE']->format('Y-m-d H:i:s');?></td>
                    <td><?php echo $result['INVOICE'];?></td>
                    <td><?php echo number_format($result['CREDIT'],2);?></td>
                    <td><?php echo number_format($result['DEBIT'],2);?></td>
                    <td><?php echo number_format($result['BALANCE'],2);?></td>
                    <td><?php echo $result['CURRENCYCODE'];?></td>

                </tr>
                <?php 
                  }
                ?>
    </tbody>
    </table> 
</div>
     
 </body>
 </html>
