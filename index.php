<?php
    require_once('clsSQLConnection.php');
    require_once('KimInclude.php');

    // House Keeping
    $conn;
    global $sessionID;
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
        $expire = time()+60*60*24*30;          
        setcookie("userID", $sessionID, $expire,'/');

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
        $TableName = 'Users';
        $mysqlObj = new clsSQLConnection();
        $mysqlObj->CreateConnection($conn);
        $userName = $_POST["f_Username"];
        $sessionID = $_POST["f_SessionID"];
        $dateTimeStamp = date('Y-m-d') . " " . date('H:i:s');

        if (isset($_POST["f_Send"]))
        {
            $mysqlObj->SendData($conn);
        }

        echo "<div id=\"container\" class=\"container\">
            <a class=\"backBtn\" href=\"/index.php\">
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
            $TableName = 'Users';
            $query = "Select userName, dateTimeStamp, message, sessionID from $TableName order by dateTimeStamp desc limit 100";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $stmt->bind_result($UserNames, $DateTimeStamps, $Messages, $SessionID);

            while($stmt->fetch())
            {
                if($SessionID == $sessionID)
                {
                    echo "
                        <p class=\"chat-usernames currentUserName\">$UserNames</p>
                        <p class=\"currentUser\">$Messages</p>
                        <span class=\"datetime\">$DateTimeStamps</span>";
                }
                else
                {
                    echo "
                        <p class=\"chat-usernames\">$UserNames</p>
                        <p class=\"otherUsers\">$Messages</p>
                        <span class=\"datetime\">$DateTimeStamps</span>";
                }
            }
            $stmt->close();
        echo "</div></div>";
        $stmt->close();
        echo "</div>";
    }
    
?>