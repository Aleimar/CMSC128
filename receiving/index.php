<?php
    session_start();
    
    if(isset($_SESSION['login_user'])){
    		if($_SESSION['login_user'] == "mtcidavao_accounting"){
    			header('Location: ../accounting/');
    			exit();
    		}
    		if($_SESSION['login_user'] == "mtcidavao_releaser"){
    			header('Location: ../releasing/');
    			exit();
    		}
    	}
    	else{
    	    header('managerdailyreceiveIndex.php');
    	    exit();
    	}
?>


<!Doctype>

	<html>
		<head>
			<title>Receiving</title>
			<!--Links the CSS in this code-->
			<link rel="stylesheet" type="text/css" href="CSS/Receiving.css">
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
				<a href = "../DailyReceivingPDF.php" target="_blank"> Print Daily Report</a>
				<a href = "../edit_password.php"> Edit Password </a>
				<a href = "../logout.php"> Logout </a>
				</div>
			</li>
			<p align = "right" ><font color = "white">WELCOME, RECEIVER!&nbsp&nbsp&nbsp&nbsp</font></p> 
			
		</ul>
			
		<br>

		<div class = "topnav">
			
			<a class = "active">Receiving Form</a>
			<a href = "dailyReceiveIndex.php">Daily Receiving Table</a>
		</div>		
		
		<!--Content div class for the white box-->
		<div class = "content">
			<!--Row div class for maximum row-->
			<div class="row">
				<div class="col-75">
					<div class="container">
						<!--form html-->
						<form action="receiver.php" method="POST">
							<div class="row">
								<!-- class for the left side inputs -->
								<div class="col-50">
									<h3>Receiving form.</h3>
									<label for="fname">Laboratory number</label>
									<input type="text" id="labno" name="lab_num" placeholder="Enter Lab no." required>
									<label for="sample">Kind of Sample</label>
									<input type="text" id="sample" name="sample_type" placeholder="Enter kind of sample" required>
									<label for="adr">Unit Price</label>
									<input type="text" id="uprice" name="un_price" placeholder="Enter unit price" required>
									<label for="submit" required>Submitted by</label>
									<input type="text" id="submit" name="submitted_by" placeholder="Enter submitted by" required>
								</div>
								<!--end of left side inputs-->
								
								<!-- class for the right side inputs-->
								<div class="col-50">
									<br><br><br>
								<label for="contractor">Contractor</label>
								<input type="text" id="contractor" name="contract" placeholder="Enter contractor" required>
								<label for="qty">Quantity</label>
								<input type="text" id="qty" name="quantity" placeholder="Enter Quantity" required>
								<label for="remarks">Test Type</label>
								<input type="text" id="test_type" name="test_type" placeholder="Enter Test Type" required>
								<label for="remarks">Remarks</label>
								<input type="text" id="remarks" name="remarks" placeholder="Enter Remarks">            
							</div>
								<!--end of class-->
						</div>
					
	
					
					</div>
				</div>
						
			
			</div>
				<!-- submit button -->
				<div class = "container" style="background-color:#f1f1f1">
						<input type="submit" value="Submit" class="btn">	
				</div>
				<!-- end of submit button -->
		</div>
		</form>
		<div class = "botnav">
		        <a style = "color: #f7f7f7;">HOME</a>
				<a href = "About.html">ABOUT</a>
				<a href = "Help.html">HELP</a>
				<a href = "FAQ.html">F.A.Q.</a>
		</div>
		<!-- end of form html class -->
		<div class = "end">
			<p> ___________________________________________________</p>
			<p> Copyright 2018. All Rights Reserved</p>
		</div>
	</body>
</html>