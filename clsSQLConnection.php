<?php

class clsSQLConnection
{
    public function CreateConnection()
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

    return $conn;
    }

    public function GetData()
    {
        $conn = $this->CreateConnection();
        $TableName = 'user_messages';
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $userName = $_SESSION["userName"];
        $query = "Select user_name, messages, dateTimeStamp from $TableName order by dateTimeStamp desc limit 100";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stmt->bind_result($UserName, $Messages, $DateTimeStamps);

        while($stmt->fetch())
        {
            if($userName == $UserName)
            {
                echo "
                    <div>
                    <p class=\"chat-usernames currentUserName\">$UserName</p>
                    <p class=\"currentUser\">$Messages</p>
                    <span class=\"datetime\">$DateTimeStamps</span>
                    </div>";
            }
            else
            {
                echo "
                    <div>
                    <p class=\"chat-usernames\">$UserName</p>
                    <p class=\"otherUsers\">$Messages</p>
                    <span class=\"datetime\">$DateTimeStamps</span>
                    </div>";
            }
        }
    }

    public function SendData($userName)
    {
        $conn = $this->CreateConnection();
        $TableName = 'user_messages';
        $message = $_POST["f_Message"];
        $dateTimeStamp = date('Y-m-d') . " " . date('H:i:s');
        
        $query = "Insert into $TableName (user_name, messages, dateTimeStamp)
                                        Values (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $BindSuccess = $stmt->bind_param("sss", $userName, $message, $dateTimeStamp);

        if ($BindSuccess)
            $success = $stmt-> execute();
        else
            echo "Bind failed" . $stmt->error;

        $stmt->close();
    }

    public function Register()
    {
        $conn = $this->CreateConnection();
        $registered = false;
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
        {
            echo "Registered Successfully";
            $registered = true;
        }

        $stmt->close();

        return $registered;
    }

    public function Login()
    {
        $conn = $this->CreateConnection();
        $TableName = "user_info";
        $userName = $_POST["f_UserName"];
        $userPass = $_POST["f_Password"];
        $authenticated = false;

        $query = "Select user_name, user_pass from $TableName where user_name = ?";
        $stmt = $conn->prepare($query);

        $BindSuccess = $stmt->bind_param("s", $userName);

        if ($BindSuccess)
            $success = $stmt->bind_result($user_name, $user_pass);
        else
            echo "Bind failed";

        if ($success)
            $stmt->execute();
        else
            echo "Bind failed";

        $stmt->fetch();

        if(password_verify($userPass, $user_pass))
        {
            echo "Login success";
            $authenticated = true;
            session_start();
            $_SESSION["userName"] =  $userName;
        }
        else
            echo "Failed login attempt";

        $stmt->close();

        return $authenticated;
    }
}

?>