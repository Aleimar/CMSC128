<?php
	session_start();

	$con = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");

	if(isset($_POST['action'])){
	    //if the action value is OVERRIDE, the user chose to proceed with the edit process
		if($_POST['action'] == "OVERRIDE"){
            
            //store all the new sample details that were just submitted
			$id 			= $_SESSION['id']; //receiving_id
			$user 			= $_SESSION['login_user'];

			$lab_no 		= $_POST['lab_no'];
			$contractor 	= $_POST['contractor'];
			$sample_type 	= $_POST['kind'];
			$test 			= $_POST['test'];
			$qty 			= $_POST['qty'];
			$unit_price 	= $_POST['unit_price'];
			$actual_payment = $_POST['actual_payment'];
			$submitted_by 	= $_POST['submitted_by'];
			$rcv_remarks 	= $_POST['rcv_remarks'];		
            
            //removes backslashes from the string, if there is any
			$lab_no 		= stripslashes($lab_no);
			$contractor 	= stripslashes($contractor);
			$sample_type 	= stripslashes($sample_type);
			$test			= stripslashes($test);
			$qty 			= stripslashes($qty);
			$unit_price 	= stripslashes($unit_price);
			$actual_payment = stripslashes($actual_payment);
			$submitted_by 	= stripslashes($submitted_by);
			$rcv_remarks 	= stripslashes($rcv_remarks);
            
            //to avoid injections attacks
			$lab_no 		= mysqli_real_escape_string($con, $lab_no);
			$contractor 	= mysqli_real_escape_string($con, $contractor);
			$sample_type 	= mysqli_real_escape_string($con, $sample_type);
			$test 			= mysqli_real_escape_string($con, $test);
			$qty 			= mysqli_real_escape_string($con, $qty);
			$unit_price 	= mysqli_real_escape_string($con, $unit_price);
			$actual_payment = mysqli_real_escape_string($con, $actual_payment);
			$submitted_by 	= mysqli_real_escape_string($con, $submitted_by);
			$rcv_remarks 	= mysqli_real_escape_string($con, $rcv_remarks);
            
            /*  If the sales_flag set in the preceding page is equal to 1,
                that means the ID is already paid. Therefore, the new payment 
                details that were submitted must also be taken into account.*/
			if(isset($_POST['sales_flag']) && ($_POST['sales_flag'] == 1)){
				if(isset($_POST['gross_sales'])){
					$gross_sales = $_POST['gross_sales'];
					$gross_sales = stripslashes($gross_sales);
					$gross_sales = mysqli_real_escape_string($con, $gross_sales);
				}
				if(isset($_POST['rebates'])){
					$rebates = $_POST['rebates'];
					$rebates = stripslashes($rebates);
					$rebates = mysqli_real_escape_string($con, $rebates);
				}
				if(isset($_POST['with_tax'])){
					$with_tax = $_POST['with_tax'];
					$with_tax = stripslashes($with_tax);
					$with_tax = mysqli_real_escape_string($con, $with_tax);
				}
				if(isset($_POST['amount_paid'])){
					$amount_paid = $_POST['amount_paid'];
					$amount_paid = stripslashes($amount_paid);
					$amount_paid = mysqli_real_escape_string($con, $amount_paid);
				}
				if(isset($_POST['or_no'])){
					$or_no = $_POST['or_no'];
					$or_no 	= stripslashes($or_no);
					$or_no 	= mysqli_real_escape_string($con, $or_no);
				}
				if(isset($_POST['payment_remarks'])){
					$payment_remarks = $_POST['payment_remarks'];
					$payment_remarks = stripslashes($payment_remarks);
					$payment_remarks = mysqli_real_escape_string($con, $payment_remarks);
				}	
				if(isset($_POST['billing_no'])){
					$billing_no = $_POST['billing_no'];
					$billing_no = stripslashes($billing_no);
					$billing_no = mysqli_real_escape_string($con, $billing_no);
				}

                //find the paid_id of the ID so that we'll know where to store the new payment details
				$sales_select 	= "SELECT paid_id FROM transactions WHERE receiving_id='$id'";
				$sales_sel_res 	= mysqli_query($con, $sales_select) or die("Error : " .mysqli_error($con));
				$res_row 		= mysqli_fetch_array($sales_sel_res, MYSQLI_ASSOC);
				$paid_id 		= $res_row['paid_id'];

                //Insert the new payment details to the edit_sales table, which will hold them temporarily.
                //These details will only replace the existing ones in the true paid table when the manager approves of/confirms it.
				$salesEdit_insert = "INSERT INTO edit_sales (paid_id, receiving_id, gross_sales, rebates, with_tax, amount_paid, or_no, remarks, billing_no, edited_by, date_edited, confirm_flag, disregard_flag) 
				VALUES ('$paid_id', '$id', '$gross_sales', '$rebates', '$with_tax', '$amount_paid', '$or_no', '$payment_remarks', '$billing_no', 
						'$user', CURDATE(), 0, 0)";
				$sales_ins_res 	= mysqli_query($con, $salesEdit_insert) or die("Error : " .mysqli_error($con));
				$res_row 		= mysqli_fetch_array($sales_sel_res, MYSQLI_ASSOC);
			}			
            
            //get the sample_id of the ID so we'll know which sample to update later
			$select 		= "SELECT sample_id FROM receiving WHERE receiving_id='$id'";
			$result 		= mysqli_query($con, $select) or die("Error : " .mysqli_error($con));
			$row			= mysqli_fetch_array($result, MYSQLI_ASSOC);
			$sample_id 		= $row['sample_id'];

			$insert = "INSERT INTO edit_receiving (sample_id, receiving_id, date_edited, lab_no, contractor, 
								   sample_type, testing_type, qty, unit_price, actual_payment, submitted_by, remarks, edited_by, confirm_flag, disregard_flag) 
						    VALUES ('$sample_id', '$id', CURDATE(), '$lab_no', '$contractor', '$sample_type', 
						    		'$test', '$qty', '$unit_price', '$actual_payment', '$submitted_by', '$rcv_remarks', '$user', 0, 0)";
			mysqli_query($con, $insert) or die("Error : " .mysqli_error($con));

            //set the edit_flag of the ID to 1 just in case
			$update = "UPDATE transactions SET edit_flag=1 WHERE receiving_id='$id'";
			mysqli_query($con, $update) or die("Error : " .mysqli_error($con));

			header('Location: ../?edit-success');
			exit();
		}
		
		//if the action value is CANCEL, the user chooses to abort the editing process and will be redirected to the home page
		elseif($_POST['action'] == "CANCEL"){
			header('Location: ../');
			exit();
		}
	}

?>