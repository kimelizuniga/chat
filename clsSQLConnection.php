<?php

class clsSQLConnection
{
    public function CreateConnection(&$conn)
    {
    // Get Heroku ClearDB connection information
    $cleardb_url            = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $cleardb_server         = $cleardb_url["host"];
    $cleardb_username       = $cleardb_url["user"];
    $cleardb_password       = $cleardb_url["pass"];
    $cleardb_db             = substr($cleardb_url["path"], 1);

    $active_group = 'default';
    $query_builder = TRUE;

    // Connect to DB
    $conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
    }

    public function GetData(&$conn)
    {
        $TableName = 'Users';
        $sessionID = $_COOKIE['userID'];
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
    }

    public function SendData($conn)
    {
        $message = $_POST["f_Message"];
        $query = "Insert into $TableName (userName, dateTimeStamp, message, sessionID)
                                        Values (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $BindSuccess = $stmt->bind_param("sssi", $userName, $dateTimeStamp, $message, $sessionID);

        if ($BindSuccess)
            $success = $stmt-> execute();
        else
            echo "Bind failed" . $stmt->error;

        $stmt->close();
    }
}

?>