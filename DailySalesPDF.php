<?php
	
	$con = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");

//The following code contains the PHP code that translated the Daily Transaction Report into a PDF version that can be later printed

//the following php that we included contaisn the connection details to the database we are to use
// require('config.php');

// we include the Daily Releasing PDF Attribute file
//This file contains the attributes of the PDF file 
require('DailySalesPDF-Attributes.php'); 

// we create a new FPDF object with the default values of PORTRAIT, unit of centimeter, and size legal
//others possible values FPDF(['L','P'], ['mm','pt','cm','in'], ['A4','Letter','Legal','A3','A5'])
$pdf = new PDF('L','cm',array(21.59,33.02));

//the following provides the number of current pages
$pdf->AliasNbPages();

//there's no page at the moment, so one is added
//AddPage(['P','L'],['A3','A4','A5','Letter','Legal'],[Rotation(multiple of 90/ positive = clockwise / negative = counter clockwise / 0 = default)])
$pdf->AddPage();

//PDF ATTRIBUTES
//SetMargins(float left, float top, float right)
//SetFont(string family[times/arial], string style[B/I/U], float size)
// $pdf->SetMargins(1.27,1.27,1.27);
$pdf->SetFont('Times','','11');
$pdf->SetMargins(1.27,1.27,1.27);

$pdf->SetWidths(array(4.4,3,3,2,1.48,2,2,2.4,2,2,2,2,2.2));
$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C','C','C','C'));

$pdf->SetFillColor(235,236,236);
$fill=true;

$date = date("Y-m-d");

$query="SELECT 
		samples.lab_no, 
		samples.contractor, 
		samples.sample_type, 
		samples.testing_type,
		samples.qty, 
		samples.unit_price, 
		transactions.amount,
		paid.gross_sales,
		paid.rebates,
		paid.with_tax,
		paid.amount_paid,
		paid.or_no,
		paid.billing_no,
		paid.remarks 
	FROM transactions, samples, receiving, paid
	WHERE paid.date='$date' 
	AND transactions.receiving_id=receiving.receiving_id
	AND receiving.sample_id=samples.sample_id
	AND transactions.paid_id=paid.paid_id
	AND transactions.sales_flag=1
	ORDER BY transactions.paid_id ASC";

$result=mysqli_query($con, $query);
$attributes=array();

if(!$result)
{
		exit();
}

while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
	$attributes[]=array(
		'lab_no' 			=> $row['lab_no'], 
		'contractor' 		=> $row['contractor'], 
		'test' 				=> $row['testing_type'],
		'qty' 				=> $row['qty'], 
		'unit_price' 		=> $row['unit_price'], 
		'amount' 			=> $row['amount'], 
		'gross_sales' 		=> $row['gross_sales'],
		'rebates'			=> $row['rebates'],
		'w_tax' 			=> $row['with_tax'],
		'amount_pd' 		=> $row['amount_paid'],
		'or_no' 			=> $row['or_no'],
		'billing_no' 		=> $row['billing_no'],
		'remarks' 			=> $row['remarks']
	);
}

$length=count($attributes);

$oldCont="";
$flag=0;
$j=1;

$contractors = array_column($attributes, 'contractor');

foreach ($attributes as $current) {
	$i=1;
	$fill=!$fill;
	$pdf->SetFills(array($fill,$fill,$fill,$fill,$fill,$fill,$fill,$fill,$fill,$fill,$fill,$fill,$fill));

	if(current($contractors)==next($contractors)){
		if($flag==0){
			$pdf->Row(array(
    			$current['contractor'],
	    		$current['lab_no'],
	    		$current['test'],
	    		$current['qty'],
	    		$current['unit_price'],
	    		$current['amount'],
	    		"", //don't print gross sales
	    		$current['rebates'],
	    		$current['w_tax'],
	    		$current['amount_pd'],
	    		$current['or_no'],
	    		$current['billing_no'],
	    		$current['remarks']));

			$flag=1;
		}else{
			$pdf->Row(array(
				"",
				$current['lab_no'],
	    		$current['test'],
	    		$current['qty'],
	    		$current['unit_price'],
	    		$current['amount'],
	    		$current['gross_sales'], //don't print gross sales
	    		$current['rebates'],
	    		$current['w_tax'],
	    		$current['amount_pd'],
	    		$current['or_no'],
	    		$current['billing_no'],
	    		$current['remarks']));
		}
	}else{
		$pdf->Row(array(
    		$current['contractor'],
    		$current['lab_no'],
    		$current['test'],
    		$current['qty'],
    		$current['unit_price'],
    		$current['amount'],
    		$current['gross_sales'],
    		$current['rebates'],
    		$current['w_tax'],
    		$current['amount_pd'],
    		$current['or_no'],
    		$current['billing_no'],
    		$current['remarks']));

		$flag=0;
	}

	if($i%19==0){
    	$pdf->AddPage();
    	$fill=true;
    }
    $i++;
}

// foreach($attributes as $current){
// 	$i=1;
// 	$fill=!$fill;
// 	$pdf->SetFills(array($fill,$fill,$fill,$fill,$fill,$fill,$fill,$fill,$fill,$fill,$fill,$fill,$fill));

// 	$currentCont=$current['contractor'];

// 	if($currentCont!=""){
// 		if($oldCont==$currentCont){
// 			if($gFlag==0){
// 				$pdf->Row(array(
//     			"", //don't print contractor
// 	    		$current['lab_no'],
// 	    		$current['test'],
// 	    		$current['qty'],
// 	    		$current['unit_price'],
// 	    		$current['amount'],
// 	    		"", //don't print gross sales
// 	    		$current['rebates'],
// 	    		$current['w_tax'],
// 	    		$current['amount_pd'],
// 	    		$current['or_no'],
// 	    		$current['billing_no'],
// 	    		$current['remarks']));

// 	    		$gFlag=1;
// 			}
// 			else{
// 				$pdf->Row(array(
//     			"", //don't print contractor
// 	    		$current['lab_no'],
// 	    		$current['test'],
// 	    		$current['qty'],
// 	    		$current['unit_price'],
// 	    		$current['amount'],
// 	    		$current['gross_sales'],
// 	    		$current['rebates'],
// 	    		$current['w_tax'],
// 	    		$current['amount_pd'],
// 	    		$current['or_no'],
// 	    		$current['billing_no'],
// 	    		$current['remarks']));
// 			}
// 		}else{
// 			$gFlag=0;

// 			$pdf->Row(array(
//     		$current['contractor'],
//     		$current['lab_no'],
//     		$current['test'],
//     		$current['qty'],
//     		$current['unit_price'],
//     		$current['amount'],
//     		$current['gross_sales'],
//     		$current['rebates'],
//     		$current['w_tax'],
//     		$current['amount_pd'],
//     		$current['or_no'],
//     		$current['billing_no'],
//     		$current['remarks']));
// 		}
// 	}
// 	$oldCont=$currentCont;
    
//     if($i%19==0){
//     	$pdf->AddPage();
//     	$fill=true;
//     }
//     $i++;
// }

$pdf->SetTitle('Daily Sales Report');
//This outputs the pdf file to the browser
$pdf->SetDisplayMode('real');
$pdf->output('I', 'MTCI-DVO_DailySalesReport'.$date.'.pdf');

//Caution: in case when the PDF is sent to the browser, nothing else must be output by the script, neither before nor after (no HTML, not even a space or a carriage return). If you send something before, you will get the error message: "Some data has already been output, can't send PDF file". If you send something after, the document might not display. 
?>