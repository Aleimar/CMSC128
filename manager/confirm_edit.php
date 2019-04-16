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

    //samples are confirmed
	if(isset($_GET['confirm_sample'])){
		$id = $_GET['confirm_sample'];
		
		//fecth all data needed

		$select1 = "SELECT sample_id, lab_no, contractor, sample_type, testing_type, qty, unit_price, actual_payment, submitted_by, remarks FROM edit_receiving WHERE receiving_id='$id'";
		$sel1_res = mysqli_query($link, $select1) or die("Error : " .mysqli_error($link));
		$sel1_row=mysqli_fetch_array($sel1_res, MYSQLI_ASSOC);

		$sample_id 		=  $sel1_row['sample_id'];
		$lab_no 		=  $sel1_row['lab_no'];
		$contractor 	=  $sel1_row['contractor'];
		$sample_type 	=  $sel1_row['sample_type'];
		$test 			=  $sel1_row['testing_type'];
		$qty 			=  $sel1_row['qty'];
		$unit_price 	=  $sel1_row['unit_price'];
		$actual_payment =  $sel1_row['actual_payment'];
		$submitted_by 	=  $sel1_row['submitted_by'];
		$remarks	 	=  $sel1_row['remarks'];


        //update all edited data

		$update1 = "UPDATE samples SET lab_no='$lab_no', contractor='$contractor', sample_type='$sample_type', testing_type='$test', qty='$qty', unit_price='$unit_price' WHERE sample_id='$sample_id'";

		$update2 = "UPDATE receiving SET actual_payment='$actual_payment', submitted_by='$submitted_by', remarks='$remarks' WHERE receiving_id='$id'";

		$update3 = "UPDATE edit_receiving SET confirm_flag=1 WHERE receiving_id='$id'";


        //query execution
		mysqli_query($link, $update1) or die("Error : " .mysqli_error($link));
		mysqli_query($link, $update2) or die("Error : " .mysqli_error($link));
		mysqli_query($link, $update3) or die("Error : " .mysqli_error($link));
	}
    
    //payment is confirmed
	if(isset($_GET['confirm_payment'])){
		$id = $_GET['confirm_payment'];

		$select2 = "SELECT paid_id, gross_sales, rebates, with_tax, amount_paid, or_no, remarks, billing_no FROM edit_sales WHERE receiving_id='$id'";
		$sel2_res = mysqli_query($link, $select2) or die("Error : " .mysqli_error($link));
		$sel2_row=mysqli_fetch_array($sel2_res, MYSQLI_ASSOC);

		$paid_id 		= $sel2_row['paid_id'];
		$gross_sales 	= $sel2_row['gross_sales'];
		$rebates 		= $sel2_row['rebates'];
		$with_tax 		= $sel2_row['with_tax'];
		$amount_paid 	= $sel2_row['amount_paid'];
		$or_no 			= $sel2_row['or_no'];
		$remarks 		= $sel2_row['remarks'];
		$billing_no 	= $sel2_row['billing_no'];


        //update all data
		$update4 = "UPDATE paid SET gross_sales='$gross_sales', rebates='$rebates', with_tax='$with_tax', amount_paid='$amount_paid', or_no='$or_no', remarks='$remarks', billing_no='$billing_no' WHERE paid_id='$paid_id'";

		$update5 = "UPDATE edit_sales SET confirm_flag=1 WHERE receiving_id='$id'";

        //query execution
		mysqli_query($link, $update4) or die("Error : " .mysqli_error($link));
		mysqli_query($link, $update5) or die("Error : " .mysqli_error($link));

	}
	
	//remove sample
	if(isset($_GET['remove_sample'])){
		$id = $_GET['remove_sample'];

        //update data and execute query
		$update6 = "UPDATE edit_receiving SET confirm_flag=0, disregard_flag=1 WHERE edit_rcv_id='$id'";
		mysqli_query($link, $update6) or die("Error : " .mysqli_error($link));
	}

	if(isset($_GET['remove_payment'])){
		$id = $_GET['remove_payment'];

		$update7 = "UPDATE edit_sales SET confirm_flag=0, disregard_flag=1 WHERE edit_sales_id='$id'";
		mysqli_query($link, $update7) or die("Error : " .mysqli_error($link));
	}

	header('Location: manager_pending.php?edit-confirmed'); //redirect as confirmed

?>
