<?php

require_once('clsSQLConnection.php');
require_once('KimInclude.php');
date_default_timezone_set('America/Toronto');

// REGISTER MAIN

WriteHeaders("Register", "Register");

if(isset($_GET["failed"]) && isset($_GET["failed"]) == "lo2p3ldms0381")
    echo "<span class=\"warning\">Failed to register</span>";

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
    echo "<a class=\"backBtn\" href=\"./\">
            <i class=\"fas fa-chevron-circle-left\"></i>
          </a>";
    echo "<div class=\"datapair\">";
        DisplayLabel("Username:");
    echo "<input type=\"text\" name=\"f_UserName\" size=\"15\" required>";
    echo "</div>";
    echo "<div class=\"datapair\">";
        DisplayLabel("First Name:");
    echo "<input type=\"text\" name=\"f_FirstName\" size=\"15\" required>";
    echo "</div>";
    echo "<div class=\"datapair\">";
        DisplayLabel("Last Name:");
    echo "<input type=\"text\" name=\"f_LastName\" size=\"15\" required>";
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
        header("Location: ./?success=r9q2l5k6xs3m5");
        exit();
    }
}

?>