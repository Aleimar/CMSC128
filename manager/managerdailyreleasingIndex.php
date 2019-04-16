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


//query for getting the attributes of user
$query="SELECT releasing_id, date_received, samples.lab_no, samples.contractor, received_by, date_released,    release_flag
			FROM releasing 
			INNER JOIN samples ON releasing.sample_id = samples.sample_id
			WHERE releasing.release_flag=1 AND date_released=CURDATE() ";

$result=mysqli_query($link,$query);     //executes the query

if(!$result)
{
    echo "Error fetching attributes " . mysqli_error($link);
    exit();
}

$attributes=array();

//fetch all data needed to display
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $attributes[]=array('releasing_id' => $row['releasing_id'], 'date' => $row['date_received'], 'lab_no' => $row['lab_no'], 'contractor' => $row['contractor'], 'received_by' => $row['received_by'],
				'date_released' => $row['date_released']);
}


   include 'manager_daily_releasing.php';       //transmit all data to this file

   end($link);
?>