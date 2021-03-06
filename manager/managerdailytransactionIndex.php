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
$query="SELECT samples.lab_no, samples.contractor, samples.testing_type,samples.qty, samples.unit_price, 
		transactions.amount, paid.gross_sales, paid.rebates, paid.with_tax, paid.amount_paid, paid.or_no, paid.billing_no, paid.remarks 
	FROM transactions, samples, receiving, paid
	WHERE paid.date=CURDATE() AND transactions.receiving_id=receiving.receiving_id AND receiving.sample_id=samples.sample_id 
	AND transactions.paid_id=paid.paid_id AND transactions.sales_flag=1 ORDER BY transactions.paid_id ASC";

$result=mysqli_query($link,$query);     //executes the query

if(!$result)
{
    echo "Error fetching attributes " . mysqli_error($link);
    exit();
}
$date=date('Y-m-d');        //fetch current data

$attributes=array();

//fetch all data needed
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $attributes[]=array('date'=>$date, 'lab_no' => $row['lab_no'],'contractor' => $row['contractor'],  'testing_type'=> $row['testing_type'], 'qty' =>$row['qty'],
                    'unit_price' => $row['unit_price'], 'amount' => $row['amount'], 'gross_sales' => $row['gross_sales'],
                    'amount_paid' =>$row['amount_paid'], 'or_no' => $row['or_no'], 'remarks' => $row['remarks']);
}


   include 'manager_daily_transaction.php';     //transmit to this file

   end($link);
?>