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

    if(isset($_POST["f_Start"]))
        DisplayChat($mysqlObj, $sessionID);
    else 
        if (isset($_POST["f_Send"]))
            DisplayChat($mysqlObj, $sessionID);
        else
            if(isset($_POST["f_Home"]))
                DisplayMainPage($mysqlObj, $sessionID);
            else
                DisplayMainPage($mysqlObj, $sessionID);

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

    function DisplayChat(&$mysqlObj, &$sessionID)
    {
        $mysqlObj = new clsSQLConnection();
        $mysqlObj->CreateConnection($conn);
        $userName = $_POST["f_Username"];
        $sessionID = $_POST["f_SessionID"];
        $expire = time()+60*60*24*30;          
        setcookie("userID", $sessionID, $expire,'/');
        $dateTimeStamp = date('Y-m-d') . " " . date('H:i:s');

        if (isset($_POST["f_Send"]))
            $mysqlObj->SendData($conn);

        echo "<div id=\"container\" class=\"container\">
            <a class=\"backBtn\" href=\"/chat/index.php\">
                <i class=\"fas fa-chevron-circle-left\"></i>
            </a>
            <form action=\"index.php\" method=\"POST\">
                <h2>Welcome <span class=\"userName\">$userName</span></h2>";
                    DisplayInput("text", "f_Username", 15, $userName, "", "userNameText");
                    DisplayInput("text", "f_SessionID", 15, $sessionID, "", "sessionID");
        echo"   <div class=\"datapair\">
                    <textarea name=\"f_Message\" id=\"message\" cols=\"50\" rows=\"4\" placeholder=\"Type here...\" autofocus></textarea>
                    <button name=\"f_Send\" id=\"sendBtn\">Send</button>";
        echo "  </div>";
        echo "
            </form>
            <div class=\"chatContainer\"><div id=\"chat\" class=\"chat\">";
            $mysqlObj->GetData($conn);
        echo "</div></div>";
        $stmt->close();
        echo "</div>";
        
        echo "<script src=\"https://code.jquery.com/jquery-3.6.0.js\" integrity=\"sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=\" crossorigin=\"anonymous\"></script>";
        echo "<script src=\"scripts/index.js\"></script>";
    }
    
?>