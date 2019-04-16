<?php
session_start();
$username = $_SESSION['login_user'];   

#establishing connection with database:
$con = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");

#error detection::
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

$query_cat = mysqli_real_escape_string($con, $_POST['category']);
$squery = mysqli_real_escape_string($con, $_POST['search']);

if(isset($_POST['search_sub'])){
  if($query_cat == "cat_date"){
    
    /*filters by date released*/
	$samp_results = mysqli_query($con, "SELECT date_received, samples.lab_no, samples.contractor,
	        releasing.received_by, releasing.date_released, releasing.release_flag
			FROM releasing 
			INNER JOIN samples ON releasing.sample_id = samples.sample_id
			WHERE releasing.release_flag=0
			AND date_released = '".$squery."'")
        	or die("Error : " .mysqli_error($con));
  }else if($query_cat == "cat_labno"){
    
    /*filters by lab number*/
	$samp_results = mysqli_query($con, "SELECT releasing_id, date_received, samples.lab_no, samples.contractor,           releasing.received_by, releasing.date_released, releasing.release_flag
			FROM releasing 
			INNER JOIN samples ON releasing.sample_id = samples.sample_id
			WHERE releasing.release_flag=0
			AND samples.lab_no = '".$squery."'")
	        or die("Error : " .mysqli_error($con));
  }else if($query_cat == "cat_contractor"){
    
    /*filters by contractor name*/
	$samp_results = mysqli_query($con, "SELECT releasing_id, date_received, samples.lab_no, samples.contractor,           releasing.received_by, releasing.date_released, releasing.release_flag
			FROM releasing 
			INNER JOIN samples ON releasing.sample_id = samples.sample_id
			WHERE releasing.release_flag=0
			AND samples.contractor = '".$squery."'")
        	or die("Error : " .mysqli_error($con));
  }
}

$attributes=array();

if(mysqli_num_rows($samp_results) > 0){
    
    /*if one or more rows are returned do following*/
	while($row = mysqli_fetch_array($samp_results, MYSQLI_ASSOC)){ 
        
        /* puts data from database into array, does the loop while valid */
		$attributes[] = array('releasing_id' => $row['releasing_id'], 'date_received' => $row['date_received'], 'lab_no' => $row['lab_no'],	'contractor' => $row['contractor'], 'received_by' => $row['received_by'],
			'date_released' => $row['date_released'], 'release_flag' => $row['release_flag']);
	}
}
else{
    /*do nothing*/
}	
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
				<a href = "../DailyReleasedPDF.php"> Print </a>
				<a href = "../Help.html"> Help </a>
				<a href = "../FAQ.html"> F.A.Q. </a>
				<a href = "../edit_password.php"> Edit Password </a>
				<a href = "../logout.php"> Logout </a>
				</div>
			</li>
			<p align = "right" ><font color = "white">WELCOME, RELEASING MANAGER!&nbsp&nbsp&nbsp&nbsp</font></p>
			</ul>
		</div>
		<br>
		<div class = "topnav">
			<a>DAILY RELEASING TABLE</a>
			<!--Refresh button-->
			<button id="myButton" class="fa fa-refresh fa spin">Refresh</button>
			<script type="text/javascript">
    				document.getElementById("myButton").onclick = function()
					{
						location.href = "releasing_result.php";
					};
		    </script>
			</div>
		</div>
	
		<div class = "content">
			<form  action="releasing_up.php" method="POST">
			<table id = "TableContent">
				<tr>
					<th>Date</th>
					<th>Lab #</th>
					<th>Contractor</th>
					<th>Received by</th>
					<th>Date Released</th>
					<th></th>
				</tr>
				<?php foreach($attributes as $current): ?>
				<tr>
					<td> <?php echo $current['date_received']; ?></td>
					<td> <?php echo $current['lab_no']; ?></td>
					<td> <?php echo $current['contractor']; ?></td>
					<td> <?php echo $current['received_by']; ?></td>
					<td> <?php echo $current['date_released']; ?></td>
					<td> 
						<div class = "container" style="background-color:#f1f1f1">
					    <button type="submit" name= "rel" value="<?php echo $current['releasing_id'];?>" class="btn"> Release </button>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
			</form>
		<div class = "container" style="background-color:#f1f1f1" align="center">
			<a href="index.php"><button type="button" name= "return" class="btn"> Search Again </button></a>
		</div>	
		<br>
		</div>
		
		<div class = "botnav">
				<a style = "color: #f7f7f7;"><b>LOGIN</b></a>
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