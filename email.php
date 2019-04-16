<?php


if (isset($_POST['submit']))
{
    
    // the message
    $msg = $_POST['comment'];
    

    // use wordwrap() if lines are longer than 70 characters
    $msg = wordwrap($msg,70);

    // send email
    mail('apvillabrille@up.edu.ph', 'Concerns' ,$msg);
    
    //send back to help page
    header('Location : Help.html');

}

else
{
     header('Location : Help.html');
}
    
?>