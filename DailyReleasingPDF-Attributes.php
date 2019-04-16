<?php

//Note that the pdf created from this file has a size Legal paper with Times New Roman font 10, with landscape page orientation, margin of 1 cm 

// we include the FPDF library file
require('fpdf.php'); 

//this is an extension of fpdf with a custom header and footer
class PDF extends FPDF
{

//----------------------------------------------------------------------------

//There is a difficulty, however, if the table is too long: page breaks. Before outputting a row, it is necessary to know whether it will cause a break or not. If it does overflow, a manual page break must be done first.

//To know the height of a MultiCell, the NbLines() method is used: it returns the number of lines a MultiCell will occupy. This is necessary so that the maximum height will be used by all cells in that row and to ensure that the width of the cell is retained and that all the cells in that row follow the same height

//Page breaks are also necessary so that we will know when to add another page when overflowing happens

var $widths;
var $aligns;
var $fills;

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function SetFills($f)
{
    //Set the array of column alignments
    $this->fills=$f;
}


function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=0.7*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    
    for($i=0;$i<count($data);$i++)
    {
        $f=$this->fills[$i];
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        if($f) {$this->Rect($x,$y,$w,$h,'F');} // If we want a border uncomment this line
        //Print the text
        $this->MultiCell($w,0.7,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);

    }
   
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h+1>$this->PageBreakTrigger){
        $this->AddPage($this->CurOrientation);
        $this->Ln(1);
    }

}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}

//---------------------------------------------------------------------------

// Page header
function Header()
{
    // Logo and the Company Details
   $this->Image('header-pdf.png',1.27,1.5,19.05);
   // Ariel,B,12
   $this->SetFont('Arial','B',11);
   $this->SetFillColor(0,225,0);
   $this->SetMargins(1.27,1.27,1.27);

   $width_cell=array(2.5,3.5,4.775,4.775,3.5);
   $this->Ln(4);
   $this->Cell($width_cell[0],0.7,'DATE',0,0,'C',true); // First header column 
   $this->Cell($width_cell[1],0.7,'LAB #',0,0,'C',true); // Second header column
   $this->Cell($width_cell[2],0.7,'CONTRACTOR',0,0,'C',true); // Third header column 
   $this->Cell($width_cell[3],0.7,'RECEIVED BY',0,0,'C',true); // Fourth header column
   $this->Cell($width_cell[4],0.7,'DATE RELEASED',0,0,'C',true); // Third header column 
}

//-------------------------------------------------------------------------

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-7);
    // Arial italic 8
    $this->SetFont('Times','B',11);
    $date=date('Y-m-d');
    // Page number
    $this->Cell(0,10,'MTCI-DVO DAILY RELEASED TRANSACTIONS '.$date,0,0,'L');
    $this->Cell(0,10,'PAGE '.$this->PageNo().'/{nb}',0,0,'R');
}

}

?>