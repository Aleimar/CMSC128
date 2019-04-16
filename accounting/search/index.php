<?php
	session_start();

	$con = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");

	if(mysqli_connect_errno()){
	    echo "Failed to connect to the database ".mysqli_connect_error();  }

    //to prevent non-accounting users to access this page
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
	else{ //if the user is not logged in, redirect them to the login page
	    header('Location: ../../');
	    exit();
	}
	$date = date('Y-m-d');

    //the purpose of sessioning the search key and category is to maintain the key and category even when the user goes to a different page
	if (isset($_GET['key']) && isset($_GET['category'])) { //if there's keyword and category
		$_SESSION['key'] = $_GET['key'];					//new search result
		$_SESSION['category'] = $_GET['category'];
	}
    
    //the str variable will be concatenated to the query later
    //the content of the str variable depends on the category chosen by the user
	if(isset($_SESSION['key']) && isset($_SESSION['category'])){
		if($_SESSION['category'] == "date"){
			$str="transactions.date=\"".$_SESSION['key']."\""; 
		}
		elseif($_SESSION['category'] == "lab_number"){
			$str="samples.lab_no=".$_SESSION['key'];
		}
		elseif($_SESSION['category'] == "contractor"){
			$str="samples.contractor=\"".$_SESSION['key']."\"";
		}
	}

	if(isset($str)){
		$query="SELECT receiving.receiving_id, receiving.date, samples.sample_id, samples.lab_no, 
		        samples.contractor, samples.sample_type, samples.testing_type, samples.qty, 
		        samples.unit_price, receiving.submitted_by, receiving.remarks, receiving.actual_payment,
		        transactions.sales_flag
				FROM transactions, receiving, samples
				WHERE transactions.receiving_id=receiving.receiving_id 
				  AND transactions.date=receiving.date
				  AND receiving.sample_id=samples.sample_id
				  AND ".$str;

		$result=mysqli_query($con, $query) or die("Error : " .mysqli_error($con));

		while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			$attributes[]=array('id' => $row['receiving_id'], 'date' => $row['date'], 'sample_id' => $row['sample_id'], 'lab_no' => $row['lab_no'], 'contractor' => $row['contractor'], 'sample_type' => $row['sample_type'], 'test' => $row['testing_type'], 'qty' => $row['qty'], 'unit_price' => $row['unit_price'], 'submitted_by' => $row['submitted_by'], 'remarks' => $row['remarks'], 'actual_payment' => $row['actual_payment'], 'sales_flag' => $row['sales_flag']);
		}
	}

?>

<!Doctype>
	
	<html>
		<head>
			<title>Accounting</title>
			<link rel="stylesheet" type="text/css" href="CSS/Manager.css">
			<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
				<a href = "../"> Home </a>
				<a href = "../../DailySalesPDF.php" target="_blank"> Print Daily Report</a>
				<a href = "../../edit_password.php"> Edit Password </a>
				<a href = "#"> Help </a>
				<a href = "../../logout.php"> Logout </a>
				</div>
			</li>
			<p align = "right" ><font color = "white">WELCOME, ACCOUNTANT!&nbsp&nbsp&nbsp&nbsp</font></p>
			</ul>
		</div>
		<br>
		<div class = "topnav">

			<a href = "../">Transactions</a>
			<a class = "active" href = "#">Search Results</a>
				<div class = "search-container">
					<form method = "get">
						<input type = "radio" name = "category" value = "date" <?php if(isset($_SESSION['category']) && $_SESSION['category'] == "date") echo "checked"; ?>>Date</input>
						<input type = "radio" name = "category" value = "lab_number" <?php if(isset($_SESSION['category']) && $_SESSION['category'] == "lab_number") echo "checked"; ?>>Lab Number</input>
						<input type = "radio" name = "category" value = "contractor" <?php if(isset($_SESSION['category']) && $_SESSION['category'] == "contractor") echo "checked"; ?>>Contractor</input>
						<input type = "text"  name = "key" placeholder = "Search... " id = "search" <?php if(isset($_SESSION['key'])) 
						echo "value=\"".$_SESSION['key']."\"" ?> >
						<button type = "submit">Submit</button>
					</form>
				</div>
		</div>
			
		<div class = "content">

		<form method="post" action="../choose.php">

			<div style="background-color: green; color:white; text-align: center; position: sticky;top:0"><b>CURRENT DATE: <?php echo $date ?></b><p></p></div>
			<table id = "TableContent">

				<?php if(isset($attributes)) { ?>

				<tr>
					<th width = "226px">Date Received</th>
					<th width = "226px">Lab #</th>
					<th width = "226px">Contractor</th>
					<th width = "226px">Kind of Sample</th>
					<th width = "226px">Type of Test</th>
					<th width = "226px">Actual Payment</th>
					<th width = "10px">Paid</th>
					<th width = "10px"></th>
				</tr>

				<?php foreach ($attributes as $current): ?>

					<tr>
					<td width = "100px"><?php echo $current['date']; ?></td>
					<td width = "150px"><?php echo $current['lab_no']; ?></td>
					<td width = "120px"><?php echo $current['contractor']; ?></td>
					<td width = "150px"><?php echo $current['sample_type']; ?></td>
					<td width = "150px"><?php echo $current['test']; ?></td>
					<td width = "150px"><?php echo $current['actual_payment']; ?></td>
					
					<?php 
					    //if the ID has not been paid, show a checkbox option
						if($current['sales_flag'] == 0){
							$show_btn=1;
							echo "<td width = \"150px\"><input class=\"largerCheckbox\" type=\"checkbox\" name=\"check_list[]\" 
							value=".$current['sample_id']."></td>";
							
						//else, show the date of when it was paid
						} else{ 
							$show_btn=0;
							$id=$current['id'];
							$paid_query="SELECT paid.date FROM transactions, paid WHERE transactions.receiving_id=$id 
							AND transactions.paid_id=paid.paid_id";
							$paid_res=mysqli_query($con, $paid_query) or die("Error : " .mysqli_error($con));
							$paid_row=mysqli_fetch_array($paid_res, MYSQLI_ASSOC);

							echo "<td width = \"150px\">".$paid_row['date']."</td>";
						}
					?>
					
					<td width = "20px"><button type="submit" name="mode" value="<?php echo $current['id']; ?>"><i class="material-icons">&#xe8b8;</i></button></td>
				
				</tr>

				<?php endforeach;
				}
				else{
				    //if the user clicks the search button with no key or category stated
					if((isset($_GET['key']) && $_GET['key']=="") || !isset($_GET['category'])) { 						//if there's category but no keyword
						unset($_SESSION['key']);							//search result is reset
						unset($_SESSION['category']);
						echo "<p>Please provide a search keyword and select its category.</p>";
					}
					//else if there is key and category stated but the query above did not produce any result
					else{
						echo "<p>No results found.</p>";
					}
				} ?>

			</table>
			
			<?php if(isset($show_btn) && ($show_btn==1)){ ?>
			<br>
				<div class="confirmBox" style="color:white; text-align: center; background-color:#f1f1f1;"><button class="btn" type="submit" name="mode" value="pay">PROCEED TO BILLING</button></div>
			<?php } ?>

		</form>
		</div>
		
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