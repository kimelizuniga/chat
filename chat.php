<?php
    require_once("clsSQLConnection.php");

    $mysqlObj = new clsSQLConnection();
    $mysqlObj->CreateConnection();

    $mysqlObj->GetData();

?>