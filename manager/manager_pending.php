<?php

session_start();    
//new session but because it is called using header
//it would retrieve all the user input from the previous session/s

$username = $_SESSION['login_user'];    
//sets the value of the username to login_user from previous session 
$link = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");
//connect to server and select to database

//---error detection---//
if (!$link)
{
    echo "Unable to connect to the database server.";
    exit();
}
if (!mysqli_set_charset($link, 'utf8'))
{
    echo "Unable to set database connection encoding.";
    exit();
}
if (!mysqli_select_db($link, "id5312484_mtci_davao"))
{
    echo "Unable to locate the mtci_davao database.";
    exit();
}

//query for getting the attributes of user
$query="SELECT edit_rcv_id, receiving_id, sample_id, lab_no, contractor, sample_type, qty, testing_type, unit_price, actual_payment, submitted_by, remarks, edited_by, date_edited FROM edit_receiving WHERE confirm_flag=0 AND disregard_flag=0";

$result=mysqli_query($link, $query) or die("Error : " .mysqli_error($link));

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $attributes[]=array('rcv_id' => $row['edit_rcv_id'], 'receiving_id' => $row['receiving_id'], 'sample_id' => $row['sample_id'], 'lab_no' => $row['lab_no'],
        					'contractor' => $row['contractor'], 'sample_type'=>$row['sample_type'], 'qty'=> $row['qty'],
                        	'testing_type' => $row['testing_type'], 'unit_price' => $row['unit_price'], 
                        	'actual_payment' => $row['actual_payment'], 'submitted_by' =>$row['submitted_by'], 'remarks' => $row['remarks'],
                        	'date_edited' => $row['date_edited'], 'edited_by' => $row['edited_by']);
    }

 ?>

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
			<a href = "managerdailyreceiveIndex.php">Daily Receiving </a>
			<a href = "managerdailytransactionIndex.php">Daily Transaction </a>
			<a href = "managerdailyreleasingIndex.php">Daily Releasing </a>
			<a class = "active" href = "manager_pending.php">Pending Edits</a>
		        <!--Search bar-->
				<!-- <div class = "search-container">
					
					<form action= "managerSearchIndexReceived.php" method = "POST">
						<input type = "radio" name = "category" value = "date">Date</input>
						<input type = "radio" name = "category" value = "lab_number" checked="checked">Lab Number</input>
						<input type = "radio" name = "category" value = "contractor">Contractor</input>
						<input type = "text"  name = "search" placeholder = "Search... ">
						<button type = "submit" name="submit">Submit</button>
					</form>
				</div> -->
		</div>
		<!--end of div "topnav"-->
		
		<!--Contents-->
		<div class = "content">
<form method="get" action="confirm_edit.php">
		<!--Sample tables-->
			<h3>Sample Details</h3>
			
	<?php if(isset($attributes)) { ?>
        <table id = "TableContent">
				<tr style="position:sticky; top:-16px">
					<th width = "150px">Date Edited</th>
					<th width = "150px">Lab #</th>
					<th width = "120px">Contractor</th>
					<th width = "150px">Kind of Sample</th>
					<th width = "90px">QTY</th>
					<th width = "150px">Kind of Testing</th>
					<th width = "150px">Unit Price</th>
					<th width = "150px">Actual Payment</th>
					<th width = "150px">Submitted by</th>
					<th width = "150px">Remarks</th>
					<th width = "150px">Edited by</th>
					<th width = "100px"></th>
					<th width = "100px"></th>
				</tr>

                <?php foreach($attributes as $current): ?>
				<tr>
					<td width = "150px"><?php echo $current['date_edited']; ?></td>
					<td width = "150px"><?php echo $current['lab_no']; ?></td>
					<td width = "120px"><?php echo $current['contractor']; ?></td>
					<td width = "150px"><?php echo $current['sample_type']; ?></td>
					<td width = "90px"><?php echo $current['qty']; ?></td>
					<td width = "150px"><?php echo $current['testing_type']; ?></td>
					<td width = "150px"><?php echo $current['unit_price']; ?></td>
					<td width = "150px"><?php echo $current['actual_payment']; ?></td>
					<td width = "150px"><?php echo $current['submitted_by']; ?></td>
					<td width = "150px"><?php echo $current['remarks']; ?></td>
					<td width = "150px"><?php echo $current['edited_by']; ?></td>
					<td width = "100px"><button type="submit" name="confirm_sample" value="<?php echo $current['receiving_id']; ?>">SAVE</button></td>
					<td width = "100px"><button type="submit" name="remove_sample" value="<?php echo $current['rcv_id']; ?>">CANCEL</button></td>
                </tr>
				<?php endforeach; ?>
			</table>
	<?php } else {
	    echo "<p>Nothing to view in this section.</p>";
	}
	?>
	
			<!--end of sample tables-->
			<br>

<?php
	$payment_sel = "SELECT
					    samples.lab_no,
					    edit_sales.receiving_id,
					    edit_sales.edit_sales_id,
					    edit_sales.paid_id,
					    edit_sales.date_edited,
					    edit_sales.receiving_id,
					    edit_sales.gross_sales,
					    edit_sales.rebates,
					    edit_sales.with_tax,
					    edit_sales.amount_paid,
					    edit_sales.or_no,
					    edit_sales.billing_no,
					    edit_sales.remarks,
					    edit_sales.edited_by
					FROM
					    edit_sales,
					    transactions,
					    receiving,
                        samples
					WHERE
					    edit_sales.receiving_id = transactions.receiving_id AND transactions.paid_id = edit_sales.paid_id AND transactions.receiving_id=receiving.receiving_id AND edit_sales.confirm_flag=0 AND receiving.sample_id=samples.sample_id AND disregard_flag=0";

	$payment_result=mysqli_query($link, $payment_sel) or die("Error : " .mysqli_error($link));

    while($row = mysqli_fetch_array($payment_result, MYSQLI_ASSOC))
    {
        $attributes_payment[]=array('receiving_id' => $row['receiving_id'], 'sales_id' => $row['edit_sales_id'], 'lab_no' => $row['lab_no'],
        					'paid_id' => $row['paid_id'], 'gross_sales'=>$row['gross_sales'], 'rebates'=> $row['rebates'],
                        	'with_tax' => $row['with_tax'], 'amount_paid' => $row['amount_paid'], 
                        	'or_no' => $row['or_no'], 'billing_no' => $row['billing_no'], 'remarks' => $row['remarks'],
                        	'date_edited' => $row['date_edited'], 'edited_by' => $row['edited_by']);
    }

?>
            <div class = "end">
            <p>________________________________________________________________________________________________________________________________________________________________</p></div>

			<h3>Payment Details</h3>
	<?php if(isset($attributes_payment)) { ?>
        <table id = "TableContent">
				<tr style="position:sticky; top:-16px">
					<th width = "150px">Date Edited</th>
					<th width = "150px">Lab #</th>
					<th width = "120px">Gross Sales</th>
					<th width = "150px">% Rebates</th>
					<th width = "150px">With Tax</th>
					<th width = "150px">Amount Paid</th>
					<th width = "150px">OR No.</th>
					<th width = "150px">Billing No.</th>
					<th width = "150px">Remarks</th>
					<th width = "150px">Edited by</th>
					<th width = "100px"></th>
					<th width = "100px"></th>
				</tr>

                <?php foreach($attributes_payment as $current): ?>
				<tr>
					<td width = "150px"><?php echo $current['date_edited']; ?></td>
					<td width = "150px"><?php echo $current['lab_no']; ?></td>
					<td width = "120px"><?php echo $current['gross_sales']; ?></td>
					<td width = "150px"><?php echo $current['rebates']; ?></td>
					<td width = "150px"><?php echo $current['with_tax']; ?></td>
					<td width = "150px"><?php echo $current['amount_paid']; ?></td>
					<td width = "150px"><?php echo $current['or_no']; ?></td>
					<td width = "150px"><?php echo $current['billing_no']; ?></td>
					<td width = "150px"><?php echo $current['remarks']; ?></td>
					<td width = "150px"><?php echo $current['edited_by']; ?></td>
					<td width = "100px"><button type="submit" name="confirm_payment" value="<?php echo $current['receiving_id']; ?>">SAVE</button></td>
					<td with = "100px"><button type="submit" name="remove_payment" value="<?php echo $current['sales_id']; ?>">CANCEL</button></td>
                </tr>
				<?php endforeach; ?>
			</table>
	<?php } else {
	    echo "<p>Nothing to view in this section.</p>";
	    }
	?>
</form>
		</div>
		<!--end of content-->
		
		<div class = "botnav">
		        <a href = "managerdailyreceiveIndex.php">HOME</a>
				<a href = "../About.html">ABOUT</a>
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