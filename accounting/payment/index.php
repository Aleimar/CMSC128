<?php
	session_start();
	
	$con = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");

    //to avoid non-accounting users from accessing this page
	if(isset($_SESSION['login_user'])){
		if($_SESSION['login_user'] == "mtcidavao_receiver"){
			header('Location: ../../receiving/');
			exit();
		}
		if($_SESSION['login_user'] == "mtcidavao_releaser"){
			header('Location: ../../releasing/');
			exit();
		}
		if($_SESSION['login_user'] == "mtcidavao_manager"){
		    header('Location: ../../managerdailyreceiveIndex.php');
		    exit();
		}
	}
	else{ //if the user is not logged in, redirect them to login page
	    header('Location: ../../');
	    exit();
	}

	if(mysqli_connect_errno()){
	    echo "Failed to connect to the database " . mysqli_connect_error();  
	}

	
    //initial total payment value
	$total = 0;
    
    //The remove value is the ID of the sample that the user wishes to remove from the list of samples to be paid
    //This part of the script will activate when the user clicks the delete button
	if (isset($_POST['remove'])) {
	    //get the position of the ID that is to be removed in the check_list array session
	    //if none is found, the return value is false
    	$key=array_search($_POST['remove'],$_SESSION['check_list']);
        
        //if the ID is found, remove it inside the session using the unset() function
    	if($key!==false) 
    		unset($_SESSION['check_list'][$key]);
    	
    	//reassign the remaining values back to the check_list array just in case
    	$_SESSION['check_list'] = array_values($_SESSION['check_list']);
    }

?>

<!Doctype>

	<html>
		<head>
			<title>Confirm Transaction</title>
			<!--Links the CSS in this code-->
			<link rel="stylesheet" href="CSS/w3.css">
			<link rel="stylesheet" type="text/css" href="CSS/modal.css">
			<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		</head>
		
	<!--Head class-->
	<body>
		<div id = "wrapper">
			<header>
				<h1> Megatesting Center Inc. </h1> 
				<h2> Civil Engineering Laboratories </h2>
			</header>
		</div>
	<!--end of Head class-->
		
		<ul>
			<li class = "dropdown">
			 <a href="javascript:void(0)" class="dropbtn">M E N U</a>
				<div class="dropdown-content">
				<a href = "../"> Home </a>
				<a href = "../../DailySalesPDF.php" target="_blank"> Print Daily Report</a>
				<a href = "../../edit_password.php"> Edit Password </a>
				<a href = "../../logout.php"> Logout </a>
				</div>
			</li>
			<p align = "right" ><font color = "white">WELCOME, ACCOUNTANT!&nbsp&nbsp&nbsp&nbsp</font></p> 
			
		</ul>
			
		<br>

			
		
		<!--Content div class for the white box-->
		<div class = "content" style="height:700px; overflow:hidden">
			<!--Row div class for maximum row-->
			<div class="row">
				<div class="col-75">
					<div ><h1 style="color: green"><center>T R A N S A C T I O N&nbsp&nbsp&nbsp&nbspD E T A I L S</center></h1></div>
					<div class="w3-container">
						<!--form html-->
							
							<div class="w3-row"><div class="w3-col s1"><br></div><div class="w3-col s10">
								
<!-- 						/////////////////////////////////////////////////////////////////////////////////////////////////// -->

						<div>
						    

							<!-- <div class="w3-white w3-centered"> -->
								
											        <div class="w3-col s5" style="background-color:#f1f1f1">
											            <br><center style="white-space:pre; color:green; font-size:22px">L I S T   O F   S A M P L E S</center>
											        	
											        	<table class="w3-table" style="vertical-align: middle; display:inline-table; color:white;"><tr style="background-color:green;">
																      <td width="40%" ><i>Lab Number</i></td>
																      <td width="30%" ><i>Quantity</i></td>
																      <td width="30%" ><i>Unit Price</i></td>
																      <td style="white-space:pre">     </td>
														</tr></table>
															      
											        	<ul class="w3-ul w3-white w3-striped w3-hoverable" style="width:100%; overflow: auto; max-height:250px">
											        	    
									
											        	<?php
														        //retrieve actual payment, qty, unit price, and submitted by values for each ID in the check_list to calculate the total amount to be paid and determine the recipient
														        if(isset($_SESSION['check_list'])){

														        	foreach($_SESSION['check_list'] as $id):
														        
														           
														            $query = "SELECT samples.sample_id, samples.lab_no, samples.qty, 
														            		         samples.unit_price, samples.contractor, receiving.submitted_by,
														            		         receiving.actual_payment
														            		  FROM samples, receiving
														            		  WHERE samples.sample_id=$id AND receiving.sample_id=samples.sample_id";
														           	$result = mysqli_query($con, $query);
														           	$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
														           	
														           	$total = ($total+$row['actual_payment']);
														           	$amt = $row['qty'] * $row['unit_price'];
														           	$recipient = $row['submitted_by'];
															    
											        	?>

															  <table class="w3-table">
														          
															      <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>#removeItem">
																  <center><li style="vertical-align: middle; display:inline-table;"><tr>
																      <td width="40%"><?php echo $row['lab_no'] ?></td>
																      <td width="30%"><?php echo $row['qty'] ?></td>
																      <td width="30%">₱ <?php echo $row['unit_price']?></td>
																      <td><button id="removeItem" type=submit name="remove" value="<?php echo $id ?>"><i class="fa fa-trash"></i></button></td>
																  </tr></center></li></div>
															  </form></table>

															  <?php endforeach; $_SESSION['total_amt'] = $total; }
															  
															  //display a note if the checklist is empty
															  else{
															  	echo "No sample was selected.";
															  } ?>

														  </ul>


														    <p style="text-align: right; margin-right: 10px; color: green"><i>Total Amount: <?php echo $total; ?> Pesos</i></p>

														</div></div>

														

							
						

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////// -->

								<!-- class for the left side inputs -->
								<div class="w3-col s1"><br/></div>
							<form method="post" action="mode.php">
								<div class="w3-col s3">
									<label for="gsales">Gross Sales</label>
									<input type="text" id="gsales" name="gross_sales" value="<?php echo $total; ?>" required placeholder="Enter Gross Sales" required>
									<label for="tax">With Tax</label>
									<input type="text" id="tax" name="with_tax" placeholder="Enter Total Price with Tax" value="0">
									<label for="or">OR #</label>
									<input type="text" id="or" name="or_no" placeholder="Enter Official Receipt Number">
									<label for="remarks">Remarks</label>
									<input type="text" id="remarks" name="remarks" placeholder="Enter Remarks">
								</div>
								<!--end of left side inputs-->
								
								
								<!-- class for the right side inputs-->
								<div class="w3-col s3">
								<label for="Rebate">% Rebates</label>
								<input type="text" id="Rebate" name="rebates" placeholder="Enter Rebate Percentage" value="0">
								<label for="amntPaid">Amount Paid</label>
								<input type="text" id="AmntPaid" name="amount" placeholder="Enter Total Amount Paid" required>
								<label for="billing">Billing #</label>
								<input type="text" id="billing" name="billing_no" placeholder="Enter Billing Number">
								<label for="recipient">Recipient</label>
								<input type="text" id="recipient" name="recipient" placeholder="Enter Recipient" value="<?php if(isset($recipient)) echo $recipient; ?>" required>            
							</div></div><div class="w3-col s1"><br></div>
								<!--end of class-->
						</div>



					<!-- submit button -->
	
					<!-- end of submit button -->
					</div>
				</div>
						
			
			</div>
			<div class = "container row" style="background-color:#f1f1f1; position:sticky; bottom:0">
						<div class="col-25">&nbsp</div>
						<div class="col-50"><button class="btn" type="submit" name="action" value="confirm">CONFIRM PAYMENT</button><button class="btn1" type="submit" name="action" value="cancel" formnovalidate>CANCEL</button></div>
						<div class="col-25">&nbsp</div>
						
			</div></div>
		</div>
	</form>
		<!-- end of form html class -->
		
    	<div class = "botnav">
		        <a href = "../">HOME</a>
				<a href = "../../About.html">ABOUT</a>
				<a href = "../../Help.html">HELP</a>
				<a href = "../../FAQ.html">F.A.Q.</a>
		</div>
		
    <div class = "end">
				<p> ___________________________________________________</p>
				<p> Copyright 2018. All Rights Reserved</p>
	</div>
	</body>
</html>
	
	