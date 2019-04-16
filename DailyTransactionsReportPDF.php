
<?php



//The following code contains the PHP code that translated the Daily Transaction Report into a PDF version that can be later printed

//the following php that we included contaisn the connection details to the database we are to use
// require('config.php');

// we include the Daily Releasing PDF Attribute file
//This file contains the attributes of the PDF file 
require('DailyTransactionsReportPDF-Attributes.php'); 

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

$pdf->SetWidths(array(3.5,4.75,5,1.2,5,2.5,2.5,3.25,2.78));
$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C'));

$pdf->SetFillColor(235,236,236);
$fill=true;

for($i=1;$i<=100;$i++){
	$fill=!$fill;
	$pdf->SetFills(array($fill,$fill,$fill,$fill,$fill,$fill,$fill,$fill,$fill));
    $pdf->Row(array('DVO-180301-0024','DVO-180301-0024','OYET/AB APONESTO',$i*100,'DVO-180301-0024','1,000.00','2,800.90','16/04/2018','16/042018'));
    if($i%19==0){
    	$pdf->AddPage();
    	$fill=true;
    }
    
}


//This outputs the pdf file to the browser
$pdf->Output();


//Caution: in case when the PDF is sent to the browser, nothing else must be output by the script, neither before nor after (no HTML, not even a space or a carriage return). If you send something before, you will get the error message: "Some data has already been output, can't send PDF file". If you send something after, the document might not display. 
?>