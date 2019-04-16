<?php
  session_start();
  
    if(isset($_SESSION['login_user'])){
        //accounting
		if($_SESSION['login_user'] == "mtcidavao_accounting"){
			header('Location: ../accounting/');
			exit();
		}
		//releasing
		else if($_SESSION['login_user'] == "mtcidavao_releaser"){
			header('Location: ../release/');
			exit();
		}
		//manager
		else if($_SESSION['login_user'] == "mtcidavao_manager"){
			header('Location: ../managerdailyreceiveIndex.php');
			exit();
		}
	}
	else{
	    header('Location: ../index.html');
	    exit();
	}
  
  $con = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");
  
  if(mysqli_connect_errno()){
    echo "Failed to connect to the database " . mysqli_connect_error();  
  }

  else{
    //retrieve values
	$lab_no = $_POST['lab_num'];
	$contractor = $_POST['contract'];
	$samp_type = $_POST['sample_type'];
	$test_type = $_POST['test_type'];
	$quantity = $_POST['quantity'];
	$unitprice = $_POST['un_price'];
	$submitted_by = $_POST['submitted_by'];
	$remarks = $_POST['remarks'];
	
	
	//security
	$lab_no = mysqli_real_escape_string($con, $lab_no);
	$contractor = mysqli_real_escape_string($con, $contractor);
	$samp_type = mysqli_real_escape_string($con, $samp_type);
	$test_type = mysqli_real_escape_string($con, $test_type);
	$quantity = mysqli_real_escape_string($con, $quantity);
	$unitprice = mysqli_real_escape_string($con, $unitprice);
	$submitted_by = mysqli_real_escape_string($con, $submitted_by);
	$remarks = mysqli_real_escape_string($con, $remarks);

	//submit & update to 'samples' table
	$query1 = "INSERT INTO samples (lab_no, contractor, sample_type, testing_type, qty, unit_price)
				VALUES('$lab_no', '$contractor', '$samp_type', '$test_type', '$quantity', '$unitprice')";
	//execute query
	mysqli_query($con, $query1) or die("Error : " .mysqli_error($con));
	
	//submit & update to 'daily_receiving' table
	$date = date('Y-m-d H:i:s');
	$last_id = mysqli_insert_id($con);
	$actualPayment = $quantity * $unitprice;
	$accounting_flag = '0';

	$query2 = "INSERT INTO receiving (date, sample_id, actual_payment, submitted_by, accounting_flag, remarks)
				VALUES('$date', '$last_id', '$actualPayment', '$submitted_by', '$accounting_flag', '$remarks')";		
				
	//execute query
	mysqli_query($con, $query2) or die("Error : " .mysqli_error($con));

	$receiving_id = mysqli_insert_id($con);
	$query3 = "INSERT INTO transactions (date, receiving_id, amount, paid_id, sales_flag, edit_flag, sent_flag) VALUES (CURDATE(), '$receiving_id', '$actualPayment', 0, 0, 0, 0)";

	//execute query
	mysqli_query($con, $query3) or die("Error : " .mysqli_error($con));
	
	header('Location: index.php');

	
  }
?>