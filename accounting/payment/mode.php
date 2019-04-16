<?php
	session_start();

	$con = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");

	if(mysqli_connect_errno()){
	    echo "Failed to connect to the database " . mysqli_connect_error();  
	}
    
    //if the action value is cancel, go back to previous page immediately
	if($_POST['action'] == "cancel"){
		header('Location: ../');
		die;
	}
	elseif($_POST['action'] == "confirm"){
		$gross_sales= $_SESSION['total_amt'];
		$with_tax	= $_POST['with_tax'];
		$or_no		= $_POST['or_no'];
		$remarks	= $_POST['remarks'];
		$rebates	= $_POST['rebates'];
		$amount 	= $_POST['amount'];
		$billing_no	= $_POST['billing_no'];
		$recipient	= $_POST['recipient'];

		//security
		$gross_sales= stripslashes($gross_sales);
		$with_tax	= stripslashes($with_tax);
		$or_no		= stripslashes($or_no);
		$remarks	= stripslashes($remarks);
		$rebates	= stripslashes($rebates);
		$amount 	= stripslashes($amount);
		$billing_no	= stripslashes($billing_no);
		$recipient	= stripslashes($recipient);

		$gross_sales= mysqli_real_escape_string($con, $gross_sales);
		$with_tax	= mysqli_real_escape_string($con, $with_tax);
		$or_no		= mysqli_real_escape_string($con, $or_no);
		$remarks	= mysqli_real_escape_string($con, $remarks);
		$rebates	= mysqli_real_escape_string($con, $rebates);
		$amount 	= mysqli_real_escape_string($con, $amount);
		$billing_no	= mysqli_real_escape_string($con, $billing_no);
		$recipient	= mysqli_real_escape_string($con, $recipient);
		
	    //insert all the submitted payment details to the paid table
		$insert="INSERT INTO paid (date, gross_sales, with_tax, rebates, amount_paid, or_no, remarks, billing_no, recipient) 
				 VALUES (CURDATE(), '$gross_sales', '$with_tax', '$rebates', '$amount', '$or_no', '$remarks', '$billing_no', '$recipient')";

		mysqli_query($con, $insert)or die("Error : " .mysqli_error($con));
		
		//get the most recently created paid_id from the paid table
		$paid_id = mysqli_insert_id($con);

		if(!empty($_SESSION['check_list'])){
		    foreach($_SESSION['check_list'] as $id):
		        $select = "SELECT transactions.trans_id FROM transactions, receiving, samples
		                    WHERE transactions.receiving_id=receiving.receiving_id 
		                    AND receiving.sample_id='$id'";
		        $result = mysqli_query($con, $select) or die("Error : " .mysqli_error($con));
		        $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
		        
		        $trans_id = $row['trans_id'];
		          
                //set the paid_id of each of the ID in the check_list to the most recently created paid_id
		       	$update = "UPDATE transactions SET paid_id='$paid_id', sales_flag='1' WHERE trans_id='$trans_id'";
		        mysqli_query($con, $update) or die("Error : " .mysqli_error($con));
		    endforeach;
		    header('Location: send_paid.php');
		}
		else{
			header('Location: ../');
		}
	}

?>