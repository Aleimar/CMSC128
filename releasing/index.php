<?php
/**
 ** RELEASING PAGE **
 **/
session_start();
$username = $_SESSION['login_user'];   

/* establishing connection with database: */
$con = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");

/*error detection:: */
if(!$con){
	echo "Unable to connect to the database server.";
	exit();
}
if(!mysqli_set_charset($con, 'utf8')){
	echo "Unable to set database connection encoding.";
	exit();	
}
if(!mysqli_select_db($con, "id5312484_mtci_davao")){
	echo "Unable to locate the desired database.";
	exit();
}

/* table operations begin */
$tquery= "SELECT releasing_id, date_received, samples.lab_no,
            samples.contractor, received_by, date_released,    release_flag, remarks
			FROM releasing 
			INNER JOIN samples ON releasing.sample_id = samples.sample_id
			WHERE releasing.release_flag=0";
$result=mysqli_query($con, $tquery) or die("Error : " .mysqli_error($con));
$attributes=array();

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
	$attributes[] = array('releasing_id' => $row['releasing_id'], 'date_received' => $row['date_received'],
	                'lab_no' => $row['lab_no'], 'contractor' => $row['contractor'],
	                'received_by' => $row['received_by'], 'date_released' => $row['date_released'],
	                'release_flag' => $row['release_flag'], 'remarks' => $row['remarks']);
}
/* table operations end */   

?>

<!Doctype>
	<html>
		<head>
			<title>Releasing Manager</title>
			<link rel="stylesheet" type="text/css" href="CSS/Releasing.css">
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
				<a href = "../DailyReleasedPDF.php" target="_blank"> Print </a>
				<a href = "../edit_password.php"> Edit Password </a>
				<a href = "../logout.php"> Logout </a>
				</div>
			</li>
			<p align = "right" ><font color = "white">WELCOME, RELEASER!&nbsp&nbsp&nbsp&nbsp</font></p>
			</ul>
		</div>
		<br>
		<div class = "topnav">
			<a class="active">READY FOR RELEASING</a>
			<!--Refresh button-->
			<button id="myBtn" class =  "fa fa-refresh fa spin"> Refresh </button>
			<script type="text/javascript">
    				document.getElementById("myBtn").onclick = function()
					{
						location.href = "index.php";
					};
		    </script>
		    <!--Search Bar-->
			<div class = "search-container">
			  <form action="releasing_result.php" method="POST">
				<input type="radio" name="category" value="cat_date" checked="checked" > Date </input>
				<input type="radio" name="category" value="cat_labno"> Lab. No. </input>
				<input type="radio" name="category" value="cat_contractor"> Contractor </input>
				<input type = "text" placeholder = "Search..." name = "search">
				<button type = "submit" name = "search_sub" >Search</button>
			  </form>
			</div>
		</div>

		<div class = "content">
		    <div style="background-color:white; position:sticky; top:-16px "><br></div>
			<form  action="releasing_up.php" method="POST">
			<table id = "TableContent">
				<tr style="position:sticky; top:0px">
					<th>Date</th>
					<th>Lab #</th>
					<th>Contractor</th>
					<th>Received by</th>
					<th>Remarks</th>
					<th></th>
				</tr>
				<?php foreach($attributes as $current): ?>
				<tr>
					<td> <?php echo $current['date_received']; ?></td>
					<td> <?php echo $current['lab_no']; ?></td>
					<td> <?php echo $current['contractor']; ?></td>
					<td> <?php echo $current['received_by']; ?></td>
					<td> <?php echo $current['remarks']; ?></td>
					<td> 
					  <div class = "container">
					    <button type="submit" name= "rel" value="<?php echo $current['releasing_id'];?>" class="btn"> Release </button>
					    
					  </div>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
			</form>
		<div style="background-color:white; position:sticky; bottom:-16px "><br></div>
		</div>
		
		<div class = "botnav">
				<a style = "color: #f7f7f7;">HOME</a>
				<a href = "About.html">ABOUT</a>
				<a href = "Help.html">HELP</a>
				<a href = "FAQ.html">F.A.Q.</a>
				
			</div>
		
		<div class = "end">
				<p> ___________________________________________________</p>
				<p> Copyright 2018. All Rights Reserved</p>
		</div>
		
	</body>
</html>