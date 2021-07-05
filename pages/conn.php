<?php

    error_reporting(0);
    $serverName = "192.168.0.45";//serverName\instanceName
    $userId = "sa";
    $userPassword = "P@ssguard11";
    $database = "TAJ_DynamicsAX";
    $connectionInfo = array("UID" => $userId,
                            "PWD" => $userPassword,
                            "Database"=> $database);
    $conn = sqlsrv_connect($serverName,$connectionInfo);
    if(!$conn){
        echo "<script>alert('Oops connection Problem')</script>";
    }

?>