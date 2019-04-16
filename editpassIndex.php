<?php

session_start();    
//new session but because it is called using header
//it would retrieve all the user input from the previous session/s

$username = $_SESSION['login_user'];    
//sets the value of the username to login_user from previous session 

//connect to server and select to database
$link = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");

//---error detection---//
if (!$link)
{
    echo "Unable to connect to the database server.";
    exit();
}
if (!mysqli_set_charset($link, 'utf8'))
{
    echo "Unable to set database connection encoding.";
    exit();
}
if (!mysqli_select_db($link, "id5312484_mtci_davao"))
{
    echo "Unable to locate the mtci_davao database.";
    exit();
}

//security
$uname= mysqli_real_escape_string($link, $_POST['uname']);
$newpsw = mysqli_real_escape_string($link, $_POST['newpsw']);
$conpsw = mysqli_real_escape_string($link, $_POST['conpsw']);

$uname=stripslashes($uname);
$newpsw=stripslashes($newpsw);
$conpsw=stripslashes($conpsw);

if (isset($_POST['submit']))
{
    if(($uname == $username) && ($newpsw == $conpsw))
    {
        $sql = "UPDATE users SET password='$newpsw' WHERE username = '$username'";

        if (!mysqli_query($link, $sql))
	    {
		    echo "Error editing password: " . mysqli_error($link);
		    exit();
	    }
	    header('Location: index.html');     //back to index
    }

    //alert user
    else
    {?>
        <script type="text/javascript"> 
           if (confirm("Invalid username/password! ")) {
                window.location.href = "index.html";
            } else {
            window.location.href = "index.html";
            }
         </script>
    <?php
    }
}
?>