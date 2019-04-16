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
    
    //to keep track of the receiving ID that is being edited
	$id=$_SESSION['id'];
    
    //query for getting the sample details of the specified ID
    $sample_query="SELECT receiving.receiving_id, receiving.date, samples.lab_no, samples.contractor, 
	             samples.sample_type, samples.testing_type, samples.qty, samples.unit_price,
	             receiving.submitted_by, receiving.remarks, receiving.actual_payment
				FROM transactions, receiving, samples 
				WHERE transactions.receiving_id=receiving.receiving_id 
			  	AND   transactions.date 	   =receiving.date
			  	AND   receiving.sample_id 	   =samples.sample_id
			  	AND   receiving.receiving_id   =$id";
	$sample_res=mysqli_query($con, $sample_query) or die("Error : " .mysqli_error($con));
	$sample_row=mysqli_fetch_array($sample_res, MYSQLI_ASSOC);

?>

<!Doctype>

	<html>
		<head>
			<title>Edit Sample Details</title>
			<!--Links the CSS in this code-->
			<link rel="stylesheet" href="CSS/w3.css">
			<link rel="stylesheet" type="text/css" href="CSS/modal.css">
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
				<a href = "../../DailySalesPDF.php" target="_blank"> Print Daily Report </a>
				<a href = "../../edit_password.php"> Edit Password </a>
				<a href = "../../logout.php"> Logout </a>
				</div>
			</li>
			<p align = "right" ><font color = "white">WELCOME, ACCOUNTANT!&nbsp&nbsp&nbsp&nbsp</font></p> 
			
		</ul>
			
		<br>

			
		
		<!--Content div class for the white box-->
		<div class = "content" style="height:700px; overflow:auto">
			<!--Row div class for maximum row-->
			<div class="row">
				<div class="col-75">
					<div ><h1 style="color: green"><center>S A M P L E&nbsp&nbsp&nbsp&nbspD E T A I L S</center></h1></div>
					<div class="container">
						<!--form html-->
					<form method="post" action="toedit.php">
							
							<div class="row">
								<!-- class for the left side inputs -->
								<div class="col-50">
									<label style="white-space:pre" for="date">Date Received          </label>
									<input type="text" id="date" name="date" placeholder="Enter Date" value="<?php echo $sample_row['date']?>" disabled>
									<label style="white-space:pre" for="labnum">Laboratory Number   </label>
									<input type="text" id="labnum" name="lab_no" placeholder="Enter Lab Number" value="<?php echo $sample_row['lab_no']?>">
									<label style="white-space:pre" for="contractor">Contractor                </label>
									<input type="text" id="contractor" name="contractor" placeholder="Enter Name of Contractor" value="<?php echo $sample_row['contractor']?>">
									<label style="white-space:pre" for="kind">Kind of Sample         </label>
									<input type="text" id="kind" name="kind" placeholder="Enter Kind of Sample" value="<?php echo $sample_row['sample_type']?>">
									<label style="white-space:pre" for="date">Type of Test             </label>
									<input type="text" id="test" name="test" placeholder="Enter Type of Test" value="<?php echo $sample_row['testing_type']?>">
								</div>
								<!--end of left side inputs-->
								
								<!-- class for the right side inputs-->
								<div class="col-50">
									<label style="white-space:pre" for="labnum" style="white-space:pre">Quantity                  </label>
									<input type="text" id="qty" name="qty" placeholder="Enter Quantity" value="<?php echo $sample_row['qty']?>">
									<label style="white-space:pre" for="contractor">Unit Price                </label>
									<input type="text" id="unit_price" name="unit_price" placeholder="Enter Unit Price" value="<?php echo $sample_row['unit_price']?>">
									<label style="white-space:pre" for="contractor">Actual Payment       </label>
									<input type="text" id="actual_payment" name="actual_payment" placeholder="Enter Name of Contractor" value="<?php echo $sample_row['actual_payment']?>">
									<label style="white-space:pre" for="kind">Submitted By           </label>
									<input type="text" id="submitted_by" name="submitted_by" placeholder="Enter User" value="<?php echo $sample_row['submitted_by']?>">
									<label style="white-space:pre" for="kind">Receiving Remarks   </label>
									<input type="text" id="rcv_remarks" name="rcv_remarks" placeholder="Enter Remarks" value="<?php echo $sample_row['remarks']?>">   
							</div>
								<!--end of class-->
						</div>
                
				<?php
				    //query for getting the payment details of the specified ID
					$payment_query="SELECT 	transactions.sales_flag, paid.date, paid.gross_sales, paid.rebates, paid.with_tax, paid.amount_paid, 
											paid.or_no, paid.billing_no, paid.remarks
									FROM 	transactions, receiving, paid
									WHERE 	transactions.receiving_id=receiving.receiving_id
									AND 	transactions.paid_id=paid.paid_id
			  						AND 	receiving.receiving_id = $id";
					$payment_res=mysqli_query($con, $payment_query) or die("Error : " .mysqli_error($con));
				 	$payment_row=mysqli_fetch_array($payment_res, MYSQLI_ASSOC); 
				?>

				<?php
				        //if the ID has not been paid, let the user know
						if($payment_row['sales_flag'] == 0) echo "<center><h4>This transaction has yet to be paid.</h4></center>";
						//else, display its payment details; create sales_flag input for future use
						else {
				?>
				        <input type="hidden" name="sales_flag" value="1">

					<div ><h1 style="color: green"><center>P A Y M E N T&nbsp&nbsp&nbsp&nbspD E T A I L S</center></h1></div>

							<div class="row">
								<div class="col-50">
									<label for="remarks">Date Paid</label>
									<input type="text" id="date_paid" name="date_paid" placeholder="Enter Date of Payment" value="<?php echo $payment_row['date']?>" disabled>
									<label for="qty">Gross Sales</label>
									<input type="text" id="gross_sales" name="gross_sales" placeholder="Enter Gross Sales" value="<?php echo $payment_row['gross_sales']?>">
									<label for="submitdBy">%Rebates</label>
									<input type="text" id="rebates" name="rebates" placeholder="Enter Rebates" value="<?php echo $payment_row['rebates']?>">
									<label for="unit">With Tax</label>
									<input type="text" id="with_tax" name="with_tax" placeholder="Enter Amount with Tax" value="<?php echo $payment_row['with_tax']?>">
								</div>
								<!--end of left side inputs-->
								
								<!-- class for the right side inputs-->
								<div class="col-50">
									<label for="remarks">Amount Paid</label>
									<input type="text" id="amount_paid" name="amount_paid" placeholder="Enter Amount Paid" value="<?php echo $payment_row['amount_paid']?>">
									<label for="remarks">OR #</label>
									<input type="text" id="or_no" name="or_no" placeholder="Enter OR Number" value="<?php echo $payment_row['or_no']?>">
									<label for="remarks">Payment Remarks</label>
									<input type="text" id="payment_remarks" name="payment_remarks" placeholder="Enter Remarks" value="<?php echo $payment_row['remarks']?>">
									<label for="remarks">Billing #</label>
									<input type="text" id="billing_no" name="billing_no" placeholder="Enter Billing Number" value="<?php echo $payment_row['billing_no']?>">             
								</div>
							</div>
						<?php } ?>
						
						
					<!-- submit button -->
						<div class = "container row" style="background-color:#f1f1f1">
							<div class="col-25">&nbsp</div>
							<div class="col-50"><input type="submit" name="action" value="OVERRIDE" class="btn"><button class="btn1" name="action" value="CANCEL">CANCEL</button></div>
						<div class="col-25">&nbsp</div>
						
			</div></div>
					<!-- end of submit button -->
					</div>
				</div>
			</div>
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