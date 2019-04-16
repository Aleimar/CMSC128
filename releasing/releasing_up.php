<?php
session_start();

#establishing connection with database:
$con = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");

#error detection::
if(!$con){
	echo "Unable to connect to the database server.";
	exit();
}
if(!mysqli_set_charset($con, 'utf8')){
	echo "Unable to set database connection encoding.";
	exit();	
}
if(!mysqli_select_db($con, "id5312484_mtci_davao")){
	echo "Unable to locate the desired database.";
	exit();
}

#updating the release flag value to 1(released)::
if(isset($_POST['rel'])){
    $btn_id = $_POST['rel'];
	$release_up = 1;
	$update = mysqli_query($con, "UPDATE releasing SET release_flag ='$release_up', date_released=CURDATE()
	       WHERE releasing_id = '$btn_id'");
}

#inserts latest row with updated release flags to released table
$curr_date = date('Y-m-d H:i:s');
$last_id = mysqli_insert_id($con);
$up_query = "INSERT INTO released(released_id, releasing_id, date_released)
				    VALUES('$last_id', '$btn_id', CURDATE())";
mysqli_query($con, $up_query) or die("Error : " .mysqli_error($con));

header ('Location: index.php');
?>
