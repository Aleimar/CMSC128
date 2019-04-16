<?php

    //starting our session
    session_start();
   //connect to server and select the database
   $con = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");
   
   
   //Get values passed from homepage.php file
    $username = $_POST['uname'];
    $password = $_POST['psw'];
    //observe that it is not user anymore but rather $_POST['user']
    //this is mainly because we used the post method to transfer all user input
    //obviously! the user inputs are now save in username and password variables

    //to prevent mySQL injection
    //mySQL injection is when the user inputs an SQL command and it might actually alter our database!
    $username = stripslashes($username);
    $password = stripslashes($password);
    $username = mysqli_real_escape_string($con ,$username );
    $password = mysqli_real_escape_string($con, $password);
    //I want you to read more about what does stripslahes and escape string do aside from injection prevention
    //and why do we want to secure our database from injection
    
    //you explain during mentoring what does the following query do
    $query="SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($con, $query) 
    or die("Invalid access! ".mysqli_error($con));
    
    $row = mysqli_fetch_array($result);

    //check if the account id and password inputted matched the data in database
    if($row['username'] == $username && $row['password'] == $password && ("" != $username || "" != $password))
    {
        $_SESSION['login_user']=$username;
        /*we save the the username as this Session's login  user
        So we save the username on session to carry this on our new session.
        */
        
        //user is the manager
        if($username == "mtcidavao_manager")
        {
            header('Location: manager/managerdailyreceiveIndex.php');
            exit();
        }
        //user is the receiving
        else if($username == "mtcidavao_receiver")
        {
            header('Location: receiving/');
            exit();
        }
        //user is the accounting
        else if($username == "mtcidavao_accounting"){
            header('Location: accounting/');
            exit();
        }
       //user is the releasing
       else if ($username == "mtcidavao_releaser")
       {
           header('Location: releasing/');
           exit();
       }
    }
    //invalid user or password
    else
    { ?>
        <script type="text/javascript"> 
           if (confirm("Invalid username/password! ")) {
                window.location.href = "index.html";
            } else {
            window.location.href = "index.html";
            }
         </script>
         <?php
    }
?>