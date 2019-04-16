<?php
	session_start();

	$con = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");

	if(isset($_POST['action'])){
		if($_POST['action'] == "OVERRIDE"){

			$date 			= date('Y-m-d');
			$id 			= $_SESSION['id'];

			$lab_no 		= $_POST['lab_no'];
			$contractor 	= $_POST['contractor'];
			$sample_type 	= $_POST['kind'];
			$qty 			= $_POST['qty'];
			$unit_price 	= $_POST['unit_price'];
			$submitted_by 	= $_POST['submitted_by'];
			$remarks 		= $_POST['remarks'];

			$lab_no 		= stripslashes($lab_no);
			$contractor 	= stripslashes($contractor);
			$sample_type 	= stripslashes($sample_type);
			$qty 			= stripslashes($qty);
			$unit_price 	= stripslashes($unit_price);
			$submitted_by 	= stripslashes($submitted_by);
			$remarks 		= stripslashes($remarks);

			$lab_no 		= mysqli_real_escape_string($con, $lab_no);
			$contractor 	= mysqli_real_escape_string($con, $contractor);
			$sample_type 	= mysqli_real_escape_string($con, $sample_type);
			$qty 			= mysqli_real_escape_string($con, $qty);
			$unit_price 	= mysqli_real_escape_string($con, $unit_price);
			$submitted_by 	= mysqli_real_escape_string($con, $submitted_by);
			$remarks 		= mysqli_real_escape_string($con, $remarks);			

			$select 		= "SELECT * FROM receiving WHERE sample_id=$id";
			$result 		= mysqli_query($con, $select) or die("Error : " .mysqli_error($con));
			$row			= mysqli_fetch_array($result, MYSQLI_ASSOC);
			$receiving_id 	= $row['receiving_id'];

			$insert = "INSERT INTO edit (sample_id, receiving_id, date_edited, lab_no, contractor, 
								   sample_type, qty, unit_price, submitted_by, remarks) 
						    VALUES ('$id', '$receiving_id', '$date', '$lab_no', '$contractor', 
						    	   '$sample_type', '$qty', '$unit_price', '$submitted_by', '$remarks')";
			mysqli_query($con, $insert) or die("Error : " .mysqli_error($con));

			$update = "UPDATE transactions SET edit_flag=1 WHERE receiving_id=$receiving_id";
			mysqli_query($con, $update) or die("Error : " .mysqli_error($con));

// 			Print '<script>alert("Successfully edited");</script>';
			header('Location: ../?edit-success');
			exit();
		}
		elseif($_POST['action'] == "CANCEL"){
			header('Location: ../');
			exit();
		}
	}

?>