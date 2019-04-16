<!Doctype>
	
	<html>
		<head>
			<title>Manager</title>
			<link rel="stylesheet" type="text/css" href="../CSS/Manager.css">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		</head>
		
	<body>
		<div id = "wrapper">
			<header>
				<h1> Megatesting Center Inc. </h1> 
				<h2> Civil Engineering Laboratories </h2>
			</header>
		</div>
		
		<div class = "nav">
			<ul>
			<li class = "dropdown">
			 <a href="javascript:void(0)" class="dropbtn">M E N U</a>
				<div class="dropdown-content">
				<a href = "../DailyReleasedPDF.php"> Print Daily Releasing</a>
				<a href = "../edit_password.php"> Edit Password </a>
				<a href = "../logout.php"> Logout </a>
				</div>
			</li>
			<p align = "right" ><font color = "white">WELCOME, MANAGER!&nbsp&nbsp&nbsp&nbsp</font></p>
			</ul>
		</div>
		<br>
		<div class = "topnav">
			<a href = "managerdailyreceiveIndex.php">Daily Receiving </a>
			<a href = "managerdailytransactionIndex.php">Daily Transaction </a>
			<a class = "active" href = "managerdailyreleasingIndex.php">Daily Releasing </a>
			<a href = "manager_pending.php">Pending Updates</a>
			<!--Refresh button-->
			<button id="myButton" class="fa fa-refresh fa spin">Refresh</button>
			<script type="text/javascript">
    				document.getElementById("myButton").onclick = function()
					{
						location.href = "managerdailyreleasingIndex.php";
					};
		    </script>
			<!--Search bar-->
				<div class = "search-container">
					<form action= "managerSearchIndexReleased.php" method = "POST">
						<input type = "radio" name = "category" value = "date">Date</input>
						<input type = "radio" name = "category" value = "lab_number" checked="checked" >Lab Number</input>
						<input type = "radio" name = "category" value = "contractor">Contractor</input>
						<input type = "text"  name = "search" placeholder = "Search... ">
						<button type = "submit" name="submit">Submit</button>
					</form>
                </div>
		</div>
		
		<div class = "content">
			<table id = "TableContent">
				<tr style="position:sticky; top:-16px">
					<th>Date</th>
					<th>Lab #</th>
					<th>Contractor</th>
					<th>Received by</th>
					<th>Date Released</th>
				</tr>
				<?php foreach($attributes as $current): ?>
				<tr>
					<td><?php echo $current['date']; ?></td>
					<td><?php echo $current['lab_no']; ?></td>
					<td><?php echo $current['contractor']; ?></td>
					<td><?php echo $current['received_by']; ?></td>
					<td><?php echo $current['date_released']; ?></td>
					
                </tr>
				<?php endforeach; ?>	
			</table>
		<br>
		</div>
		
			<div class = "botnav">
		        <a style = "color: #f7f7f7;">HOME</a>
				<a href = "About_in.html">ABOUT</a>
				<a href = "../Help.html">HELP</a>
				<a href = "../FAQ.html">F.A.Q.</a>
		</div>
		
		<div class = "end">
				<p> ___________________________________________________</p>
				<p> Copyright 2018. All Rights Reserved</p>
			</div>
		
		
	</body>
</html>