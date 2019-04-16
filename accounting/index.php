<?php
	session_start();
	
	$con = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");
    if(mysqli_connect_errno()){
	    echo "Failed to connect to the database " . mysqli_connect_error();  
	}
	
	//to prevent non-accounting users from accessing this page
	if(isset($_SESSION['login_user'])){
		if($_SESSION['login_user'] == "mtcidavao_receiver"){
			header('Location: ../receiving/');
			exit();
		}
		if($_SESSION['login_user'] == "mtcidavao_releaser"){
			header('Location: ../releasing/');
			exit();
		}
		if($_SESSION['login_user'] == "mtcidavao_manager"){
		    header('Location: ../managerdailyreceiveIndex.php');
		    exit();
		}
	}
	else{ //if the user is not logged in, redirect them to login page
	    header('Location: ../');
	    exit();
	}

	$date = date('Y-m-d');

    //query for getting all transaction entries that are not yet paid
	$query="SELECT receiving.receiving_id, receiving.date, samples.sample_id, samples.lab_no, 
	        samples.contractor, samples.sample_type, samples.testing_type, samples.qty, samples.unit_price,
	        receiving.submitted_by, receiving.remarks, receiving.actual_payment
			FROM transactions, receiving, samples 
			WHERE transactions.receiving_id=receiving.receiving_id 
			  AND transactions.date=receiving.date
			  AND receiving.sample_id=samples.sample_id
			  AND transactions.sales_flag=0";
	$result=mysqli_query($con, $query) or die("Error : " .mysqli_error($con));

	while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$attributes[]=array('id' => $row['receiving_id'], 'date' => $row['date'], 'sample_id' => $row['sample_id'], 'lab_no' => $row['lab_no'], 'contractor' => $row['contractor'], 'sample_type' => $row['sample_type'], 'test' => $row['testing_type'], 'qty' => $row['qty'], 'unit_price' => $row['unit_price'], 'submitted_by' => $row['submitted_by'], 'remarks' => $row['remarks'], 'actual_payment' => $row['actual_payment']);
	}
?>

<!Doctype>
	
	<html>
		<head>
			<title>Accounting</title>
			<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
			<link rel="stylesheet" type="text/css" href="CSS/Accounting.css">
			<!-- <link rel="stylesheet" type="text/css" href="CSS/modal.css"> -->
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
			<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		</head>
		
	<body>
	     
		<!--<div id = "wrapper" style="opacity:0.8">-->
		<!--	<div style="height:100px; background-image: url('Images/labPNG.png'); background-repeat:no-repeat; background-position: right; background-size: 500px 250px; background-overflow:visible;">-->
		<!--	    <h1 >   M e g a T e s t i n g   C e n t e r   I n c .</h1>-->
		<!--		<h2 >        C  I  V  I  L       E  N  G  I  N  E  E  R  I  N  G       L  A  B  O  R  A  T  O  R  I  E  S </h2>-->
				
		<!--	</div>-->
		<!--</div>-->
		
		<div id = "wrapper">
			<header>
				<h1> Megatesting Center Inc. </h1> 
				<h2> Civil Engineering Laboratories </h2>
			</header>
		</div>
		
		
		<div class = "nav" >
			<ul>
			<li class = "dropdown">
			 <a href="javascript:void(0)" class="dropbtn">M E N U</a>
				<div class="dropdown-content" >
				<a href = "../DailySalesPDF.php" target="_blank"> Print Daily Report </a>
				<a href = "../edit_password.php"> Edit Password </a>
				<a href = "../logout.php"> Logout </a>
				</div>
			</li>
			<p align = "right" ><font color = "white">WELCOME, ACCOUNTANT!&nbsp&nbsp&nbsp&nbsp</font></p>
			</ul>
		</div>
		
		<br>
		
		<div class = "topnav">
			<a class = "active" href = "https://megatesting-unofficial.000webhostapp.com/accounting/">Transactions</a>
			<a href = "search/">Search Results</a>
		<form action = "search/" method = "get">
				<div class = "search-container">
					<input type = "radio" name = "category" value = "cat_date">Date</input>
					<input type = "radio" name = "category" value = "lab_number">Lab Number</input>
					<input type = "radio" name = "category" value = "contractor">Contractor</input>
					<input type = "text"  name = "key" placeholder = "Search... " id = "search">
					<button type = "submit">Submit</button>
				</div>
			 </form>
		</div>
			
		<div class = "content">

		<form method="post" action="choose.php">

			<div class="container" style="background-color: green; color:white; text-align: center; position:sticky; top: -16px;"><b >CURRENT DATE: <?php echo $date ?></b></div>
			
			<?php
			    //if the query above found the desired results
			    if(isset($attributes)) { ?>
			
			<table id = "TableContent">

				<tr style="position:sticky; top:5px;">
					<th width = "226px">Date Received</th>
					<th width = "226px">Lab #</th>
					<th width = "226px">Contractor</th>
					<th width = "226px">Kind of Sample</th>
					<th width = "226px">Type of Test</th>
					<th width = "226px">Actual Payment</th>
					<th width = "10px">Paid</th>
					<th width = "10px"></th>
				</tr>
                
				<?php foreach ($attributes as $current):?>

					<tr>
					<td width = "100px"><?php echo $current['date']; ?></td>
					<td width = "150px"><?php echo $current['lab_no']; ?></td>
					<td width = "120px"><?php echo $current['contractor']; ?></td>
					<td width = "150px"><?php echo $current['sample_type']; ?></td>
					<td width = "150px"><?php echo $current['test']; ?></td>
					<td width = "150px"><?php echo $current['actual_payment']; ?></td>
					<td width = "50px"><input class="largerCheckbox" type="checkbox" name="check_list[]" 
						value="<?php echo $current['sample_id']; ?>"></td>
					<td width = "20px"><button type="submit" name="mode" value="<?php echo $current['id']; ?>"><i class="material-icons">&#xe8b8;</i></button></td>
				
				</tr>

				<?php endforeach; ?>

			</table>
			<div class="container" style="color:white; text-align: center; background-color:#f1f1f1; position:sticky; bottom:-16px"><br><button class="btn" type="submit" name="mode" value="pay">PROCEED TO BILLING</button></div>
		        <?php
		            //if the query above failed to find the desired results
				    }else{
					    echo "<p>No transactions to display.</p>";
				} ?>
		</form>
    
		</div>
		
	
    <?php
        //if the check_list value returned is negative, meaning the check_list is empty
        if(isset($_GET['checklist'])){
            if($_GET['checklist'] < 0){
                //prompt the user to select a sample before proceeding to billing page
                echo "<script>alert('Select a transaction to proceed.');</script>";
            }
        }
    ?>
    
  <!--  	   <div class = "botnav">-->
		<!--        <a style = "color: yellow">HOME</a>-->
		<!--		<a href = "../About.html">ABOUT</a>-->
		<!--		<a href = "../Help.html">HELP</a>-->
		<!--		<a href = "../FAQ.html">F.A.Q.</a>-->
		<!--</div>-->
		
		<div class = "botnav">
		        <a style = "color: #f7f7f7;">HOME</a>
				<a href = "About.html">ABOUT</a>
				<a href = "Help.html">HELP</a>
				<a href = "FAQ.html">F.A.Q.</a>
		</div>
		<div class = "end" >
			<p > ___________________________________________________</p>
			<p> Copyright 2018. All Rights Reserved</p>
		</div>
    
	</body>
	</html>