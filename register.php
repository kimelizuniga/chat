<?php

require_once('clsSQLConnection.php');
require_once('KimInclude.php');
date_default_timezone_set('America/Toronto');

// REGISTER MAIN

WriteHeaders("Register", "Register");

if(isset($_POST["f_RegisterSubmit"]))
    DisplayRegister();
else
    DisplayRegisterForm();

WriteFooters();

// END MAIN

// FUNCTIONS

function DisplayRegisterForm()
{
    echo "<form class=\"mainContainer\" action=\"?\" method=\"POST\">";
    echo "<a class=\"backBtn\" href=\"./index.php\">
            <i class=\"fas fa-chevron-circle-left\"></i>
          </a>";
    echo "<div class=\"datapair\">";
        DisplayLabel("Username:");
        DisplayInput("text", "f_UserName", "15");
    echo "</div>";
    echo "<div class=\"datapair\">";
        DisplayLabel("First Name:");
        DisplayInput("text", "f_FirstName", "15");
    echo "</div>";
    echo "<div class=\"datapair\">";
        DisplayLabel("Last Name:");
        DisplayInput("text", "f_LastName", "15");
    echo "</div>";
    echo "<div class=\"datapair\">";
        DisplayLabel("Password (8 character minimum):");
    echo "<input type=\"password\" name=\"f_Password\" minlength=\"8\" required id=\"pass\">";
    echo "</div>";
        DisplayButton("f_RegisterSubmit", "Register");
    echo "</form>";
}

function DisplayRegister()
{
    $mysqlObj = new clsSQLConnection();

    if($mysqlObj->Register())
    {
        header("Location: http://localhost/chat-app?success=r9q2l5k6xs3m5");
        exit();
    }
}

?>