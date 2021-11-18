<?php

class clsSQLConnection
{
    public function CreateConnection(&$conn)
    {
    // Get Heroku ClearDB connection information
    // $cleardb_url            = parse_url(getenv("CLEARDB_DATABASE_URL"));
    // $cleardb_server         = $cleardb_url["host"];
    // $cleardb_username       = $cleardb_url["user"];
    // $cleardb_password       = $cleardb_url["pass"];
    // $cleardb_db             = substr($cleardb_url["path"], 1);

    // $active_group = 'default';
    // $query_builder = TRUE;

    // // Connect to DB
    // $conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

    // Connect to local DB
    $conn = new mysqli ("localhost", "root", "mysql", "chat");
    }

    public function GetData($conn)
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
                    <div>
                    <p class=\"chat-usernames currentUserName\">$UserNames</p>
                    <p class=\"currentUser\">$Messages</p>
                    <span class=\"datetime\">$DateTimeStamps</span>
                    </div>";
            }
            else
            {
                echo "
                    <div>
                    <p class=\"chat-usernames\">$UserNames</p>
                    <p class=\"otherUsers\">$Messages</p>
                    <span class=\"datetime\">$DateTimeStamps</span>
                    </div>";
            }
        }
    }

    public function SendData($conn)
    {
        $TableName = 'Users';
        $message = $_POST["f_Message"];
        $userName = $_POST["f_Username"];
        $sessionID = $_POST["f_SessionID"];
        $dateTimeStamp = date('Y-m-d') . " " . date('H:i:s');
        
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

    public function Register($conn)
    {
        $TableName = "user_info";
        $user_name = $_POST["f_UserName"];
        $first_name = $_POST["f_FirstName"];
        $last_name = $_POST["f_LastName"];
        $user_pass = password_hash($_POST["f_Password"], PASSWORD_DEFAULT);
        $dateRegistered = date('Y-m-d');

        $query = "Insert into $TableName (user_name, first_name, last_name,
                                          user_pass, user_registered)
                                          Values (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $BindSuccess = $stmt->bind_param("sssss",
                                         $user_name, $first_name, $last_name,
                                         $user_pass, $dateRegistered);
                        
        if ($BindSuccess)
            $success = $stmt->execute();
        else
            echo "Bind failed" . $stmt->error;

        if($success)
            echo "Registered Successfully";

        $stmt->close();
    }
}

?>