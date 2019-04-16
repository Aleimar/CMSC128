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
$query="SELECT receiving.date, samples.lab_no, samples.contractor, samples.sample_type, samples.qty, 
samples.testing_type, samples.unit_price, receiving.actual_payment, receiving.submitted_by, receiving.remarks FROM receiving, 
samples WHERE receiving.sample_id=samples.sample_id AND receiving.date=CURDATE()";

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
    $attributes[]=array('date' => $row['date'], 'lab_no' => $row['lab_no'],'contractor' => $row['contractor'], 'sample_type'=>$row['sample_type'], 'qty'=> $row['qty'],
                    'testing_type' => $row['testing_type'], 'unit_price' => $row['unit_price'], 'actual_payment' => $row['actual_payment'],
                    'submitted_by' =>$row['submitted_by'], 'remarks' => $row['remarks']);
}


   include 'manager_daily_receiving.php';       //transmit all data to this file

   end($link);
?>