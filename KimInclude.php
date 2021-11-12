<?php
function WriteHeaders($Heading="Welcome", $TitleBar="MySite")
{
    echo "
    <!doctype html> 
    <html lang = \"en\">
        <head>
            <meta charset = \"UTF-8\">
            <link rel=\"stylesheet\" href=\"https://use.fontawesome.com/releases/v5.15.4/css/all.css\" integrity=\"sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm\" crossorigin=\"anonymous\">
            <link rel =\"stylesheet\" type = \"text/css\" href=\"/stylesheets/index.css\"/>
            <title>$TitleBar</title>
            
        </head>
    <body>";
}

function DisplayContactInfo()
{
    echo "
    <footer>
        Questions? Comments?
        <a href = \"mailto:kimeli.zuniga@student.sl.on.ca\">kimeli.zuniga@student.sl.on.ca</a>
    </footer>";
}

function WriteFooters()
{
    DisplayContactInfo();
    echo "<script src=\"https://code.jquery.com/jquery-3.6.0.js\" integrity=\"sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=\" crossorigin=\"anonymous\"></script>";
    echo "<script src=\"/scripts/index.js\"></script>";
    echo "
    </body>
    </html>
    ";
}

function DisplayLabel($prompt)
{
    echo "<label>" . $prompt . "</label>";
}

function DisplayInput($Type, $Name, $Size, $Value="", $Placeholder="", $Id="")
{
    echo "<input id=\"$Id\" type = \"$Type\" placeholder=\"$Placeholder\" 
         name = \"$Name\" Size = \"$Size\" value = \"$Value\" autocomplete=\"off\" required>";
}   

function DisplayImage($FileName, $alt, $height, $width)
{
    echo "<img src = \"$FileName\" alt = \"$alt\" height = \"$height\" width = \"$width\">";
}

function DisplayButton($Name, $Text, $FileName = "", $alt = "")
{
    if($FileName == "")
        echo "<button name=\"$Name\" >$Text</button>";
    else
    {
        echo "<button name=\"$Name\" >";
        DisplayImage($FileName, $alt, 60, 60);
        echo "</button>";
        
    }
}

?>