<?php
    require_once("clsSQLConnection.php");

    $conn;
    $mysqlObj = new clsSQLConnection();
    $mysqlObj->CreateConnection($conn);

    $mysqlObj->GetData($conn);

?>