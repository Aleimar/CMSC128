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
			
			<a href = "index.php">Receiving Form</a>
			<a class = "active">Daily Receiving Table</a>
		</div>		
		
		<!--Content div class for the white box-->
		<div class = "content">
		    <div style="background-color:white; position:sticky; top:-50px "><br></div>
				<table id = "TableContent">
				<tr style="position:sticky; top:-30px">
					<th width = "100px">Date</th>
					<th width = "150px">Lab #</th>
					<th width = "120px">Contractor</th>
					<th width = "150px">Kind of Sample</th>
					<th width = "90px">QTY</th>
					<th width = "150px">Kind of Testing</th>
					<th width = "150px">Unit Price</th>
					<th width = "150px">Actual Payment</th>
					<th width = "150px">Submitted by</th>
					<th width = "150px">Remarks</th>
				</tr>
				<?php foreach($attributes as $current): ?>
				<tr>
					<td width = "100px"><?php echo $current['date']; ?></td>
					<td width = "150px"><?php echo $current['lab_no']; ?></td>
					<td width = "120px"><?php echo $current['contractor']; ?></td>
					<td width = "150px"><?php echo $current['sample_type']; ?></td>
					<td width = "90px"><?php echo $current['qty']; ?></td>
					<td width = "150px"><?php echo $current['testing_type']; ?></td>
					<td width = "150px"><?php echo $current['unit_price']; ?></td>
					<td width = "150px"><?php echo $current['actual_payment']; ?></td>
					<td width = "150px"><?php echo $current['submitted_by']; ?></td>
					<td width = "150px"><?php echo $current['remarks']; ?></td>
                </tr>
				<?php endforeach; ?>
			</table>
			 <div style="background-color:white; position:sticky; bottom:-50px "><br></div>
		</div>
		</form>
		<!-- end of form html class -->
		<div class = "botnav">
		        <a style = "color: #f7f7f7;">HOME</a>
				<a href = "About.html">ABOUT</a>
				<a href = "../Help.html">HELP</a>
				<a href = "../FAQ.html">F.A.Q.</a>
		</div>
		<div class = "end">
			<p> ___________________________________________________</p>
			<p> Copyright 2018. All Rights Reserved</p>
		</div>
	</body>
</html>