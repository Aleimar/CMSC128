<?php

//The following code contains the PHP code that translated the Daily Released Table into a PDF version that can be later printed
$con = mysqli_connect("localhost", "id5312484_megatesting", "cmsc128ily", "id5312484_mtci_davao");

//the following php that we included contaisn the connection details to the database we are to use
// require('config.php');

// we include the Daily Releasing PDF Attribute file
//This file contains the attributes of the PDF file 
require('DailyReleasingPDF-Attributes.php'); 

// we create a new FPDF object with the default values of PORTRAIT, unit of centimeter, and size legal
//others possible values FPDF(['L','P'], ['mm','pt','cm','in'], ['A4','Letter','Legal','A3','A5'])
$pdf = new PDF('P','cm',array(21.59,33.02));

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

$pdf->SetWidths(array(2.5,3.5,4.775,4.775,3.5));
$pdf->SetAligns(array('C','C','C','C','C'));

$pdf->SetFillColor(235,236,236);
$fill=true;

$pdf->Ln(1);

$select = "SELECT releasing.date_received, samples.lab_no, samples.contractor, releasing.received_by, 
            releasing.date_released
            FROM releasing, samples 
            WHERE releasing.sample_id=samples.sample_id 
            AND releasing.date_released=CURDATE() 
            AND releasing.release_flag=1
            ORDER BY releasing.releasing_id ASC";
$result = mysqli_query($con, $select);
$attributes=array();

if(!$result)
{
		exit();
}

while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
	$attributes[]=array(
	    'date_received'     => $row['date_received'],
		'lab_no' 			=> $row['lab_no'], 
		'contractor' 		=> $row['contractor'], 
		'received_by' 		=> $row['received_by'],
		'date_released' 	=> $row['date_released']
	);
}

foreach($attributes as $current){
	$fill=!$fill;
	$pdf->SetFills(array($fill,$fill,$fill,$fill,$fill));
    $pdf->Row(array($current['date_received'], $current['lab_no'], $current['contractor'], $current['received_by'], $current['date_released']));
}
$date=date('Y-m-d');
$pdf->SetTitle('Daily Releasing Report');
//This outputs the pdf file to the browser
$pdf->SetDisplayMode('real');
$pdf->output('I', 'MTCI-DVO_DailyReleasingReport'.$date.'.pdf');

//Caution: in case when the PDF is sent to the browser, nothing else must be output by the script, neither before nor after (no HTML, not even a space or a carriage return). If you send something before, you will get the error message: "Some data has already been output, can't send PDF file". If you send something after, the document might not display. 
?>