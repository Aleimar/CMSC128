<!Doctype>
	
	<html>
		<head>
			<title>Manager Daily Receiving</title>
			<link rel="stylesheet" type="text/css" href="../CSS/Manager.css">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		</head>
	<body>
	    <!--div id "wrapper" for the top banner-->
		<div id = "wrapper">
			<header>
				<h1> Megatesting Center Inc. </h1> 
				<h2> Civil Engineering Laboratories </h2>
			</header>
		</div>
		<!--end of top banner-->
		
		<!--Div "nav" for the top menu -->
		<div class = "nav">
			<ul>
	        <!--Dropdown menu-->
			<li class = "dropdown">
			 <a href="javascript:void(0)" class="dropbtn">M E N U</a>
				<div class="dropdown-content">
				<a href = "../DailyReceivingPDF.php"> Print Daily Receiving  </a>
				<a href = "../edit_password.php"> Edit Password </a>
				<a href = "../logout.php"> Logout </a>
				</div>
			</li>
			<!--end of dropdown menu-->
			<p align = "right" ><font color = "white">WELCOME, MANAGER!&nbsp&nbsp&nbsp&nbsp</font></p>
			</ul>
		</div>
		<!--end of div "nav"-->
		<br>
		
		<!--Div "topnav" for the manager table tabs-->
		<div class = "topnav">
			<a class = "active" href = "managerdailyreceiveIndex.php">Daily Receiving </a>
			<a href = "managerdailytransactionIndex.php">Daily Transaction </a>
			<a href = "managerdailyreleasingIndex.php">Daily Releasing </a>
			<a href = "manager_pending.php">Pending Updates</a>
			<!--Refresh button-->
			<button id="myButton" class="fa fa-refresh fa spin">Refresh</button>
			<script type="text/javascript">
    				document.getElementById("myButton").onclick = function()
					{
						location.href = "managerdailyreceiveIndex.php";
					};
		    </script>
		        <!--Search bar-->
				<div class = "search-container">
					
					<form action= "managerSearchIndexReceived.php" method = "POST">
						<input type = "radio" name = "category" value = "date">Date</input>
						<input type = "radio" name = "category" value = "lab_number" checked="checked">Lab Number</input>
						<input type = "radio" name = "category" value = "contractor">Contractor</input>
						<input type = "text"  name = "search" placeholder = "Search... ">
						<button type = "submit" name="submit">Submit</button>
					</form>
				</div>
		</div>
		<!--end of div "topnav"-->
		
		<!--Contents-->
		<div class = "content">
		    <div style="background-color:white; position:sticky; top:-16px "><br></div>
		<!--Sample tables-->
		
        <table id = "TableContent">
				<tr style="position:sticky; top:0px">
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
			<!--end of sample tables-->
			 <div style="background-color:white; position:sticky; bottom:-16px "><br></div>
		</div>
		<!--end of content-->
		
		<div class = "botnav">
		        <a style = "color: #f7f7f7;">HOME</a>
				<a href = "../About_in.html">ABOUT</a>
				<a href = "../Help.html">HELP</a>
				<a href = "../FAQ.html">F.A.Q.</a>
		</div>
		
		<!--div "end" for the copyrights-->
		<div class = "end">
			<p> ___________________________________________________</p>
			<p> Copyright 2018. All Rights Reserved</p>
		</div>
		<!--end of div "end"-->
	</body>
</html>

<!--END-->