<?php
    require_once('clsSQLConnection.php');
    require_once('KimInclude.php');

    // House Keeping
    $conn;
    $sessionID;
    $mysqlObj = new clsSQLConnection();
    $mysqlObj->CreateConnection($conn); // Creates the sql connection

    // MAIN
    WriteHeaders("Chat App");
    $mysqlObj->GetData($conn);
    echo "Hello there heroku, Kim here";
    WriteFooters();

    // END OF MAIN

    

    // FUNCTIONS

    function DisplayMainPage(&$sessionID)
    {
        $sessionID = mt_rand();

        echo "<form class=\"mainPage\" action=\"index.php\" method=\"POST\">";
        echo "<h1>Chat App</h1>";
        echo "<div class=\"datapair\"";
            DisplayLabel("Username: ");
            DisplayInput("text", "f_Username", 15);
            DisplayInput("text", "f_SessionID", 15, $sessionID, "", "sessionID");
            DisplayButton("f_Start", "Start");
        echo "</div>";
        echo "</form>";
    }
    
?>