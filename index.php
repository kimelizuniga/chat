<?php
    require_once('clsSQLConnection.php');
    require_once('KimInclude.php');
    date_default_timezone_set('America/Toronto');

    // House Keeping
    $conn;
    $sessionID = "";
    $mysqlObj = new clsSQLConnection();
    $mysqlObj->CreateConnection($conn); // Creates the sql connection

    // MAIN
    WriteHeaders("Chat App");

    if(isset($_POST["f_Start"]))
        DisplayChat($mysqlObj, $sessionID, $conn);
    else 
        if (isset($_POST["f_Send"]))
            DisplayChat($mysqlObj, $sessionID, $conn);
        else
            if(isset($_POST["f_Home"]))
                DisplayMainPage($mysqlObj, $sessionID);
            else
                if(isset($_POST["f_Register"]))
                    DisplayRegisterForm();
                else
                    if(isset($_POST["f_RegisterSubmit"]))
                        DisplayRegister($mysqlObj, $conn);
                    else
                        DisplayMainPage($mysqlObj, $sessionID);

    WriteFooters();

    // END OF MAIN

    // FUNCTIONS

    function DisplayMainPage(&$sessionID)
    {
        $sessionID = mt_rand();
        $expire = time()+60*60*24*30;          
        setcookie("userID", $sessionID, $expire,'/');

        echo "<form class=\"mainPage\" action=\"index.php\" method=\"POST\">";
        echo "<h1>Chat App</h1>";
        echo "<div class=\"datapair mainInput\"";
            DisplayLabel("Username: ");
            DisplayInput("text", "f_Username", 15);
            DisplayInput("text", "f_SessionID", 15, $sessionID, "", "sessionID");
        echo "</div>";
            DisplayButton("f_Start", "Start");
            DisplayButton("f_Register", "Register");
        echo "</form>";
    }

    function DisplayChat(&$mysqlObj, &$sessionID, $conn)
    {
        $TableName = 'Users';
        $userName = $_POST["f_Username"];
        $sessionID = $_POST["f_SessionID"];
        $dateTimeStamp = date('Y-m-d') . " " . date('H:i:s');

        if (isset($_POST["f_Send"]))
        {
            $mysqlObj->SendData($conn);
        }

        echo "<div id=\"container\" class=\"container\">
            <a class=\"backBtn\" href=\"./index.php\">
                <i class=\"fas fa-chevron-circle-left\"></i>
            </a>
            <h2>Welcome <span class=\"userName\">$userName</span></h2>";
            echo "<form action=\"?\" method=\"POST\">";
                    DisplayInput("text", "f_Username", 15, $userName, "", "userNameText");
                    DisplayInput("text", "f_SessionID", 15, $sessionID, "", "sessionID");
        echo"   <div class=\"datapair chatSend\">
                    <textarea name=\"f_Message\" id=\"message\" cols=\"50\" rows=\"4\" placeholder=\"Type here...\" autofocus type=\"submit\"></textarea>
                    <button name=\"f_Send\" id=\"sendBtn\">Send</button>";
        echo "</form></div>
            <div class=\"chatContainer\"><div id=\"chat\" class=\"chat\">";
                $mysqlObj->GetData($conn);
        echo "</div></div>";
        echo "</div>";

        echo "<script src=\"https://code.jquery.com/jquery-3.6.0.js\" integrity=\"sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=\" crossorigin=\"anonymous\"></script>";
        echo "<script src=\"./public/scripts/index.js\"></script>";
    }

    function DisplayRegisterForm()
    {
        echo "<form action=\"?\" method=\"POST\">";
            DisplayLabel("Username:");
            DisplayInput("text", "f_UserName", "15");
            DisplayLabel("First Name:");
            DisplayInput("text", "f_FirstName", "15");
            DisplayLabel("Last Name:");
            DisplayInput("text", "f_LastName", "15");
            DisplayLabel("Password (8 character minimum):");
        echo "<input type=\"password\" name=\"f_Password\" minlength=\"8\" required id=\"pass\">";
            DisplayButton("f_RegisterSubmit", "Register");
        echo "</form>";
    }

    function DisplayRegister(&$mysqlObj, $conn)
    {
        $mysqlObj->Register($conn);
    }
    
?>