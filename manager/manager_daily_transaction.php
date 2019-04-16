<!Doctype>
	
	<html>
		<head>
			<title>Manager Daily Transaction</title>
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
		<!--end div "wrapper"-->
		
		<!--nav class for the menu-->
		<div class = "nav">
			<ul>
			<!--dropdown menu-->
			<li class = "dropdown">
			 <a href="javascript:void(0)" class="dropbtn">M E N U</a>
			    <!--dropdown contents-->
				<div class="dropdown-content">
				    <a href = "../DailySalesPDF.php"> Print Daily Transactions </a>
				    <a href = "../edit_password.php"> Edit Password </a>
				    <a href = "../logout.php"> Logout </a>
				</div>
				<!--end of dropdown contents-->
			</li>
			<!--end of dropdown menu-->
			<p align = "right" ><font color = "white">WELCOME, MANAGER!&nbsp&nbsp&nbsp&nbsp</font></p>
			</ul>
		</div>
		<!--end of "nav" class-->
		<br>
		
		<!--class "topnav" for the manager tabs-->
		<div class = "topnav">
            <a href = "managerdailyreceiveIndex.php">Daily Receiving </a>
			<a class = "active" href = "managerdailytransactionIndex.php">Daily Transaction </a>
			<a href = "managerdailyreleasingIndex.php">Daily Releasing </a>
			<a href = "manager_pending.php">Pending Updates</a>
			    
			    <!--Refresh button-->
			    <button id="myButton" class="fa fa-refresh fa spin">Refresh</button>
			        <script type="text/javascript">
    				    document.getElementById("myButton").onclick = function()
					        {
						        location.href = "managerdailytransactionIndex.php";
					        };
		                </script>
		        <!--div class "search-container" for the search container-->
				<div class = "search-container">
					<form action= "managerSearchIndexTransaction.php" method = "POST">
						<input type = "radio" name = "category" value = "date">Date</input>
						<input type = "radio" name = "category" value = "lab_number" checked="checked">Lab Number</input>
						<input type = "radio" name = "category" value = "contractor">Contractor</input>
						<input type = "text"  name = "search" placeholder = "Search... ">
						<button type = "submit" name="submit">Submit</button>
					</form>
				</div>
		</div>
		<!--end of class "topnav"-->
		
		<!--div class "content" for the contents-->
		<div class = "content">
		     <div style="background-color:white; position:sticky; top:-16px "><br></div>
		    <!--Tables-->
			<table id = "TableContent">
				<tr style="position:sticky; top:0px">
					<th width = "100px">Date</th>
					<th width = "120px">Contractor</th>
					<th width = "150px">Lab #</th>
					<th width = "150px">Kinds of Testing</th>
					<th width = "150px">Unit Price</th>
					<th width = "90px">QTY</th>
					<th width = "150px">Amount</th>
					<th width = "150px">Gross Sales</th>
					<th width = "150px">Amount Paid</th>
					<th width = "150px">OR#</th>
					<th width = "150px">Remarks</th>
				</tr>
				<?php foreach($attributes as $current): ?>
				<tr>
					<?php echo "<td width = \"100px\">" . $current['date'] . "</td>"; ?>
					<?php echo "<td width = \"120px\">" . $current['contractor'] . "</td>"; ?>
					<?php echo "<td width = \"150px\">" . $current['lab_no'] . "</td>"; ?>
					<?php echo "<td width = \"150px\">" . $current['testing_type'] . "</td>"; ?>
					<?php echo "<td width = \"150px\">" . $current['unit_price'] ."</td>"; ?>
					<?php echo "<td width = \"90px\">" . $current['qty'] . "</td>"; ?>
					<?php echo "<td width = \"150px\">" . $current['amount'] . "</td>"; ?>
					<?php echo "<td width = \"150px\">" . $current['gross_sales'] . "</td>"; ?>
					<?php echo "<td width = \"150px\">" . $current['amount_paid'] . "</td>"; ?>
					<?php echo "<td width = \"150px\">" .$current['or_no'] . "</td>" ?>
					<?php echo "<td width = \"150px\">" . $current['remarks'] . "</td>"; ?>
                </tr>
                <?php endforeach; ?>
			</table>
			<!--End of tables-->
			<br>
			 <div style="background-color:white; position:sticky; bottom:-16px "><br></div>
		</div>
		<!--End of div class "contents"-->
		
	    <div class = "botnav">
		        <a style = "color: #f7f7f7;">HOME</a>
				<a href = "About_in.html">ABOUT</a>
				<a href = "../Help.html">HELP</a>
				<a href = "../FAQ.html">F.A.Q.</a>
		</div>
		
		<!--div class "end" for the copyrights-->
		<div class = "end">
				<p> ___________________________________________________</p>
				<p> Copyright 2018. All Rights Reserved</p>
		</div>
		<!--end of div class "end"-->
		
		
	</body>
</html>

<!--END-->