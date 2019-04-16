<?php

$con = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");

//The following code contains the PHP code that translated the Daily Recieved Transactions into a PDF version that can be later printed

//the following php that we included contaisn the connection details to the database we are to use
// require('config.php');

// we include the Daily Releasing PDF Attribute file
//This file contains the attributes of the PDF file 
require('DailyReceivingPDF-Attributes.php'); 

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

$pdf->SetWidths(array(3.5,5,6.5,1.5,3,3,4,4));
$pdf->SetAligns(array('C','C','C','C','C','C','C','C'));

$pdf->SetFillColor(235,236,236);
$fill=true;

$date = date("Y-m-d");

$query="SELECT 
	samples.lab_no, 
	samples.contractor, 
	samples.sample_type, 
	samples.qty, 
	samples.unit_price, 
	receiving.actual_payment, 
	receiving.submitted_by, 
	receiving.remarks 
	FROM receiving, samples
	WHERE receiving.date='$date' 
	AND receiving.sample_id=samples.sample_id";

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
		'sample_type' 		=> $row['sample_type'], 
		'qty' 				=> $row['qty'], 
		'unit_price' 		=> $row['unit_price'], 
		'actual_payment' 	=> $row['actual_payment'], 
		'submitted_by' 		=> $row['submitted_by'], 
		'remarks' 			=> $row['remarks']);
}

foreach($attributes as $current){
	$i=1;
	$fill=!$fill;
	$pdf->SetFills(array($fill,$fill,$fill,$fill,$fill,$fill,$fill,$fill));
    $pdf->Row(array(
    		$current['lab_no'],
    		$current['contractor'],
    		$current['sample_type'],
    		$current['qty'],
    		$current['unit_price'],
    		$current['actual_payment'],
    		$current['submitted_by'],
    		$current['remarks']));
    if($i%19==0){
    	$pdf->AddPage();
    	$fill=true;
    }
    $i++;
}

$pdf->SetTitle('Daily Receiving Report');
//This outputs the pdf file to the browser
$pdf->SetDisplayMode('real');
$pdf->output('I', 'MTCI-DVO_DailyReceivingReport'.$date.'.pdf');

//Caution: in case when the PDF is sent to the browser, nothing else must be output by the script, neither before nor after (no HTML, not even a space or a carriage return). If you send something before, you will get the error message: "Some data has already been output, can't send PDF file". If you send something after, the document might not display. 
?>