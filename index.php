<?php
require_once('clsSQLConnection.php');
require_once('KimInclude.php');
date_default_timezone_set('America/Toronto');

// MAIN
$authenticated = false;

WriteHeaders("Chat App", "Chat App");

if(isset($_GET["success"]) && isset($_GET["success"]) == "r9q2l5k6xs3m5")
    echo "Registered Successfully";

if(isset($_POST["f_Login"]))
{
    $mysqlObj = new clsSQLConnection();
    $conn = $mysqlObj->CreateConnection();

    $authenticated = $mysqlObj->Login();
    if($authenticated)
        DisplayChat();
    else
        DisplayMainPage();
}
else
    if(isset($_POST["f_Send"]))
        DisplayChat();
    else
        DisplayMainPage();

WriteFooters();

// END OF MAIN

// FUNCTIONS

function DisplayMainPage()
{
    echo "<form class=\"mainContainer\" action=\"index.php\" method=\"POST\">";
    echo "<h1>Chat App</h1>";
    echo "<div class=\"datapair mainInput\">";
        DisplayLabel("Username:");
        DisplayInput("text", "f_UserName", 15);
    echo "</div>";
    echo "<div class=\"datapair mainInput\">";
        DisplayLabel("Password:");
        DisplayInput("password", "f_Password", 15);
    echo "</div>";
        DisplayButton("f_Login", "Login");
    echo "<a href=\"register.php\">Register</a>";
    echo "</form>";
}

function DisplayChat()
{
    $mysqlObj = new clsSQLConnection();
    $conn = $mysqlObj->CreateConnection();
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $userName = $_SESSION["userName"];
    $dateTimeStamp = date('Y-m-d') . " " . date('H:i:s');

    if (isset($_POST["f_Send"]))
    {
        $mysqlObj->SendData($userName);
    }

    echo "<div id=\"container\" class=\"container\">
        <a class=\"backBtn\" href=\"./index.php\">
            <i class=\"fas fa-chevron-circle-left\"></i>
        </a>
        <h2>Welcome <span class=\"userName\">$userName</span></h2>";
    echo "<form action=\"?\" method=\"POST\">";
    echo"   <div class=\"datapair chatSend\">
                <textarea name=\"f_Message\" id=\"message\" cols=\"50\" rows=\"4\" placeholder=\"Type here...\" autofocus type=\"submit\"></textarea>
                <button name=\"f_Send\" id=\"sendBtn\">Send</button>";
    echo "</form></div>
        <div class=\"chatContainer\"><div id=\"chat\" class=\"chat\">";
            $mysqlObj->GetData();
    echo "</div></div>";
    echo "</div>";

    echo "<script src=\"https://code.jquery.com/jquery-3.6.0.js\" integrity=\"sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=\" crossorigin=\"anonymous\"></script>";
    echo "<script src=\"./public/scripts/index.js\"></script>";
}

?>