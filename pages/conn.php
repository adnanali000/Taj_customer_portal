<?php

    $serverName = "192.168.0.45";//serverName\instanceName
    $userId = "sa";
    $userPassword = "P@ssguard11";
    $database = "TAJ_DynamicsAX";
    $connectionInfo = array("UID" => $userId,
                            "PWD" => $userPassword,
                            "Database"=> $database);
    $conn = sqlsrv_connect($serverName,$connectionInfo);
    // if($conn){
    //     echo "connection successfully done";
    // }else{
    //     echo "connection failed";
    // }

?>