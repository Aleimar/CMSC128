<?php
	session_start();

	$con = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");

	if(mysqli_connect_errno()){
	    echo "Failed to connect to the database " . mysqli_connect_error();  
	}
    
    //query for getting the necessary details needed by the releasing from the samples, receiving, and transactions tables
	$select = "SELECT transactions.trans_id, receiving.date, samples.contractor, receiving.submitted_by,  samples.sample_id, paid.remarks FROM transactions, receiving, samples, paid
			   WHERE transactions.receiving_id=receiving.receiving_id AND receiving.sample_id=samples.sample_id
			    AND transactions.paid_id=paid.paid_id AND transactions.sales_flag=1 AND transactions.sent_flag=0";
	$res = mysqli_query($con, $select)or die("Error : " .mysqli_error($con));

	while($row=mysqli_fetch_array($res, MYSQLI_ASSOC)){
		$date 		= $row['date'];
		$received_by =$row['submitted_by'];
		$trans_id 	= $row['trans_id'];
		$sample_id	= $row['sample_id'];
		$remarks    = $row['remarks'];

		$insert = "INSERT INTO releasing (date_received, received_by, trans_id, sample_id, date_released, release_flag, remarks) 
				   VALUES ('$date', '$received_by', '$trans_id', '$sample_id', '1900-01-01 00:00:00.000', '0', '$remarks')";
		mysqli_query($con, $insert)or die("Error : " .mysqli_error($con));
	}

	$update = "UPDATE transactions SET sent_flag=1 WHERE paid_id!=0";
	mysqli_query($con, $update)or die("Error : " .mysqli_error($con));

	unset($_SESSION['check_list']);

	header('Location: ../index.php?transac-success');
	exit();

?>