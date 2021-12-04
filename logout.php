<?php

session_start();
session_destroy(); // logout user
session_start(); 
$_SESSION["logout"] = true; // create a logout session variable

header("Location: ./");
exit();
    
?>