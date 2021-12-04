<?php

session_start();
session_destroy();
header("Location: ./");
echo "<p class=\"success\">Logged out successfully!</p>";
exit();
    
?>