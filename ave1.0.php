<?php
//============================================================+
// PDF generator view
//============================================================+

/**
 * Creates an PDF document using TCPDF
 * @package com.tecnick.tcpdf
 * @author Rodrigo Caruso
 * @since 2018-12-19
 */

// Include the main TCPDF library (search for installation path).
//require_once('tcpdf_include.php');
require_once('./TCPDF/tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//this clas draws the sheets
	//it needs the map matrix with magic characters to work
	
	
	public $name ="";
	public $starti = 25;
	public $startj = 105;
	public $wd = 77.14;
	public $hg = 90;
	public $tilesw = 6;
	public $tilesh = 7;
	public $tilew = 0;
	public $tileh = 0;
	public $scale = 0.6;

	//Page header
	public function Header() {
		
	}
	
	public function Sheet($map,$name=''){
		//Draws a sheet based on the matrix
		
		// Logo
		//$image_file = K_PATH_IMAGES.'logo_example.jpg';
		//$image_file = K_PATH_IMAGES."../../../images/PMSCS.jpg";
		//$this->Image($image_file, 10, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		
		// Set font
		$this->SetFont('helvetica', 'B', 16);
				
		//Seguir formatacao pelo modelo:
		//	tcpdf.org/examples/example_005
		
		$pdf = $this;
		
		$pdf->SetLineStyle(array('width' => 0.05, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->RoundedRect($pdf->starti, $pdf->startj, $pdf->wd, $pdf->hg, 6.50, '0000');
		
		$pdf->tilew = $pdf->wd/$pdf->tilesw;
		$pdf->tileh = $pdf->hg/$pdf->tilesh;
		
		$pdf->RoundedRect($pdf->starti-20, $pdf->startj-2, $pdf->tilew * 10, $pdf->tileh * $pdf->tilesh * 1.04, 0, '0000');
		
		//Navigates trough all map matrix squares, drawing them on PDF
		for($i=0;$i < $pdf->tilesw; $i++){
			for($j=0;$j < $pdf->tilesh; $j++){
				if(	$map[$j][$i]!= ''){
					if($map[$j][$i] == 'O'){
						//Draws an O castle
						$io = $this->starti + $this->tilew * $i + $this->tilew /2;
						$jo = $this->startj + $this->tileh * $j + $this->tileh /2;
						$pdf->bigcircle($io,$jo);
					}
					else if($map[$j][$i] == 'V'){
						//Draws an V castle
						$io = $this->starti + $this->tilew * $i + $this->tilew /2;
						$jo = $this->startj + $this->tileh * $j + $this->tileh /2;
						$pdf->bigtriangle($io,$jo);
					}
					else if( strpos('ABCDEF' , $map[$j][$i])  !== false ){
						//Draws an farm
						$io = $this->starti + $this->tilew * $i + $this->tilew /2 - 3.1;
						$jo = $this->startj + $this->tileh * $j + $this->tileh /2 - 4.5;
						$this->SetFont('helvetica', '', 20);
						$this->Text($io,$jo, $map[$j][$i] );
					}
					else if(strlen($map[$j][$i]) > 0){
						//Draws 1-4 grapes on the square as indicated by matrix item
						$objects = str_split($map[$j][$i]);
						
						if(sizeof($objects) == 1){
							//There is only 1 grape, draws it on center
							$o = $objects[0];
							$io = $this->starti + $this->tilew * $i + $this->tilew /2;
							$jo = $this->startj + $this->tileh * $j + $this->tileh /2;
							if($o=='o') $pdf->tinycircle($io,$jo);
							else if($o=='v')$pdf->tinytriangle($io,$jo);
						}
						if(sizeof($objects) == 2){
							//There are 2 grapes, center height and split width
							$o = $objects[0];
							$io = $this->starti + $this->tilew * $i + $this->tilew /3;
							$jo = $this->startj + $this->tileh * $j + $this->tileh /2;
							if($o=='o') $pdf->tinycircle($io,$jo);
							else if($o=='v')$pdf->tinytriangle($io,$jo);
							
							$o = $objects[1];
							$io = $this->starti + $this->tilew * $i + $this->tilew /3 * 2;
							$jo = $this->startj + $this->tileh * $j + $this->tileh /2;
							if($o=='o') $pdf->tinycircle($io,$jo);
							else if($o=='v')$pdf->tinytriangle($io,$jo);
						}
						
						if(sizeof($objects) == 3){
							//There are 3 grapes
							$o = $objects[0];
							$io = $this->starti + $this->tilew * $i + $this->tilew /3;
							$jo = $this->startj + $this->tileh * $j + $this->tileh /3;
							if($o=='o') $pdf->tinycircle($io,$jo);
							else if($o=='v')$pdf->tinytriangle($io,$jo);
							
							$o = $objects[1];
							$io = $this->starti + $this->tilew * $i + $this->tilew /3 * 2;
							$jo = $this->startj + $this->tileh * $j + $this->tileh /3;
							if($o=='o') $pdf->tinycircle($io,$jo);
							else if($o=='v')$pdf->tinytriangle($io,$jo);
							
							$o = $objects[2];
							$io = $this->starti + $this->tilew * $i + $this->tilew /2;
							$jo = $this->startj + $this->tileh * $j + $this->tileh /3 * 2;
							if($o=='o') $pdf->tinycircle($io,$jo);
							else if($o=='v')$pdf->tinytriangle($io,$jo);
						}
						
						if(sizeof($objects) == 4){
							//There are 4 grapes
							$o = $objects[0];
							$io = $this->starti + $this->tilew * $i + $this->tilew /3;
							$jo = $this->startj + $this->tileh * $j + $this->tileh /3;
							if($o=='o') $pdf->tinycircle($io,$jo);
							else if($o=='v')$pdf->tinytriangle($io,$jo);
							
							$o = $objects[1];
							$io = $this->starti + $this->tilew * $i + $this->tilew /3 * 2;
							$jo = $this->startj + $this->tileh * $j + $this->tileh /3;
							if($o=='o') $pdf->tinycircle($io,$jo);
							else if($o=='v')$pdf->tinytriangle($io,$jo);
							
							$o = $objects[2];
							$io = $this->starti + $this->tilew * $i + $this->tilew /3;
							$jo = $this->startj + $this->tileh * $j + $this->tileh /3 * 2;
							if($o=='o') $pdf->tinycircle($io,$jo);
							else if($o=='v')$pdf->tinytriangle($io,$jo);
							
							$o = $objects[3];
							$io = $this->starti + $this->tilew * $i + $this->tilew /3 * 2;
							$jo = $this->startj + $this->tileh * $j + $this->tileh /3 * 2;
							if($o=='o') $pdf->tinycircle($io,$jo);
							else if($o=='v')$pdf->tinytriangle($io,$jo);
						}
						
					}
					
				}
			}
		}
		
		//PDF Grid inner lines
		$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 1.5, 'color' => array(0, 0, 0)));
		for($k=1;$k<$pdf->tilesw; $k++){
			$pdf->Line($pdf->starti+($pdf->tilew*$k), $pdf->startj, $pdf->starti+($pdf->tilew*$k), $pdf->startj+($pdf->tileh*$pdf->tilesh));
		}
		for($k=1;$k<$pdf->tilesh; $k++){
			$pdf->Line($pdf->starti, $pdf->startj+($pdf->tileh*$k), $pdf->starti+($pdf->tilew*$pdf->tilesw), $pdf->startj+($pdf->tileh*$k) );
		}
		
		
		
		$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->RoundedRect($pdf->starti, $pdf->startj, $pdf->tilew * $pdf->tilesw, $pdf->tileh * $pdf->tilesh, 0, '0000');
		
		//public $starti = 25;
		//public $startj = 5;
		
		//Draws map name on PDF
		$pdf->mapname($pdf->starti - 16.5, $pdf->startj-2, $name);
		
		//Draws the help cards with the 6 numbers and street shapes
		$pdf->helpcard1($pdf->starti - 18.5, $pdf->startj+15);
		$pdf->helpcard2($pdf->starti - 18.5, $pdf->startj+28);
		$pdf->helpcard3($pdf->starti - 18.5, $pdf->startj+41);
		$pdf->helpcard4($pdf->starti - 18.5, $pdf->startj+54);
		$pdf->helpcard5($pdf->starti - 18.5, $pdf->startj+67);
		$pdf->helpcard6($pdf->starti - 18.5, $pdf->startj+80);
		
		//Draws the scoring spaces for 5 farms
		$pdf->SetLineStyle(array('width' => 0.05, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->score($pdf->starti + $pdf->wd + 3,$pdf->startj);
		$pdf->score($pdf->starti + $pdf->wd + 3,$pdf->startj+9.5);
		$pdf->score($pdf->starti + $pdf->wd + 3,$pdf->startj+19);
		$pdf->score($pdf->starti + $pdf->wd + 3,$pdf->startj+28.5);
		$pdf->score($pdf->starti + $pdf->wd + 3,$pdf->startj+38);
		
		//Draws the scoring spaces for 2 castles
		$pdf->score($pdf->starti + $pdf->wd + 3,$pdf->startj+49, "V");
		$pdf->score($pdf->starti + $pdf->wd + 3,$pdf->startj+58.5, "O");
		
		//Draws the negative bonus space (this is different from original, only one space
		$pdf->score($pdf->starti + $pdf->wd + 3,$pdf->startj+69, "-5");
		
		//Draws the final score space
		$pdf->score($pdf->starti + $pdf->wd + 3,$pdf->startj+80, "=");
		
		/*
		$pdf->StartTransform();
        $pdf->Rotate(90);
        $this->SetFont('helvetica', '', 7);
        $this->SetTextColor(0,0,0);
        //$pdf->MultiCell(100, 10, "rotated text", 0, 'C', false, 0, "", "", true, 0, false, true, 0, "T", false, true);
            $pdf->Translate(100, 10);
            $pdf->Rect(186, -184, 100, 100, 'D');
            $pdf->Rect(185, -185, 100, 100, 'D');
            $pdf->Text(385, -185, 'Translate');
        $this->SetFont('helvetica', '', 10);
        $this->SetTextColor(255,255,255);
        $pdf->StopTransform();
        */
	}
	

	// Page footer
	public function Footer() {
	}
	
	function tinytriangle($i,$j){
		$size = 3; //triangle radius (grape)
		$halfsize = $size/2;
		$coef = 0.57; //pi/2
		$this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$this->SetFillColor(115, 115, 115);
		$this->Polygon(array($i-$halfsize,$j-$halfsize*$coef  ,$i+$halfsize,$j-$halfsize*$coef  ,$i,$j+$halfsize),'F');
		$this->SetFillColor(255, 255, 255);
	}
	
	function tinycircle($i,$j){
		$size = 3; //circle radius (grape)
		$radius = $size/2;
		$this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(115, 115, 115)));
		$this->Circle($i,$j,$radius, 0.5, 0, 'L');
		$this->Circle($i,$j, 1.5);
	}
	
	function bigtriangle($i,$j, $scale = 1){
		$size = 8 * $scale; //Big triangle radius (castle)
		$halfsize = $size/2;
		$coef = 0.57;//pi/2
		$this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$this->SetFillColor(115, 115, 115);
		$this->Polygon(array($i-$halfsize,$j-$halfsize*$coef  ,$i+$halfsize,$j-$halfsize*$coef  ,$i,$j+$halfsize),'F');
		$this->SetFillColor(255, 255, 255);
	}
	
	function bigcircle($i,$j, $scale = 1){
		$size = 8 * $scale; //Big circle radius (castle)
		$radius = $size/2;
		$this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(115, 115, 115)));
		$this->Circle($i,$j,$radius, 1, 0, 'L');
	}
	
	function score($i,$j, $symbol = ""){
		//Draws a score placeholder. May be farm, castle, -5 penalty or final score
		
		$this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$this->SetFillColor(220, 220, 220);
		
		if($symbol != '='){
			//Anyt score other than final total score
			$this->RoundedRect($i, $j, $this->tilew*$this->scale, $this->tileh*$this->scale, $this->tilew/10, '0011', 'F');
			$this->Polygon(array(
				$i+$this->tilew*$this->scale, $j,
				$i+$this->tilew*$this->scale * 1.2, $j + ($this->tileh*$this->scale)/2,
				$i+$this->tilew*$this->scale, $j+$this->tileh*$this->scale
			),'F');
		}
		
		//Background
		$this->RoundedRect($i+$this->tilew*$this->scale * 1.3, $j, $this->tilew*$this->scale, $this->tileh*$this->scale, $this->tilew/10, '1111', 'F');
		$this->SetFont('helvetica', '', 20);
		
		if($symbol == 'O'){
			//Circle castle score
			$this->bigcircle($i+$this->tilew*$this->scale * 0.5, $j+$this->tileh*$this->scale * 0.5, 0.8);
		}
		else if($symbol == 'V'){
			//Triangle castle score
			$this->bigtriangle($i+$this->tilew*$this->scale * 0.5, $j+$this->tileh*$this->scale * 0.5, 0.8);
		}
		else if($symbol == '-5'){
			//Penalty score
			$this->SetFont('helvetica', '', 10);
			$this->Text($i+3,$j, 'Ø');
			$this->Text($i+1,$j+2.5, '×');
			$this->Text($i+3,$j+3.6, '-5');
		}
		else if($symbol == '='){
			//Final total score
			$this->SetFont('helvetica', '', 20);
			$this->Text($i+3,$j, $symbol);
		}
	}
	
	function mapname($i,$j,$name){
		$this->SetFillColor(100, 100, 100);
		$this->SetTextColor(255,255,255);
		if(strtoupper($name)=='DISABLEA' || strtoupper($name)=='DISABLEB' || strtoupper($name)=='DISABLEC'){
			$this->SetFont('helvetica', '', 26);
			$this->RoundedRect($i, $j, $this->tilew*$this->scale*2, $this->tileh*$this->scale*1.5, $this->tilew/10, '0110', 'F');
			$this->Text($i+3.5,$j, strtoupper(substr($name,-1,1)) );	
		}
		else{
			$this->SetFont('helvetica', '', 10);
			$this->RoundedRect($i-3.5, $j, $this->tilew*$this->scale*2.5, $this->tileh*$this->scale*1.2, $this->tilew/10, '0100', 'F');
			$this->Text($i-2.5,$j, 'CUSTOM:');
			$this->SetFont('helvetica', '', 7);
			$this->Text($i-3.5,$j+5, $name);
		}
		
		//$this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0)));
		
		
		
		$this->SetTextColor(55,55,55);
	}
	
	function helpcard1($i,$j){
		$this->SetFont('helvetica', '', 15);
		$this->Text($i,$j, '1');
		$i = $i + 6;
		$this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$this->SetFillColor(155, 155, 155);
		$this->RoundedRect($i, $j, $this->tilew*$this->scale, $this->tileh*$this->scale, $this->tilew/8, '1111', 'F');
		$this->SetFillColor(255, 255, 255);
		$this->RoundedRect($i+$this->tilew/2.75*$this->scale, $j-1, $this->tilew/4*$this->scale, $this->tileh/1.55*$this->scale, $this->tilew/8*$this->scale, '0000','F');
		$this->RoundedRect($i-0.2, $j+$this->tileh/2.75*$this->scale, $this->tilew/1.55*$this->scale, $this->tileh/4*$this->scale, $this->tilew/8*$this->scale, '1100','F');
	}
	function helpcard2($i,$j){
		$this->SetFont('helvetica', '', 15);
		$this->Text($i,$j, '2');
		$i = $i + 6;
		$this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$this->SetFillColor(155, 155, 155);
		$this->RoundedRect($i, $j, $this->tilew*$this->scale, $this->tileh*$this->scale, $this->tilew/8, '1111', 'F');
		$this->SetFillColor(255, 255, 255);
		$this->RoundedRect($i+$this->tilew/2.75*$this->scale, $j-1, $this->tilew/4*$this->scale, $this->tileh/1.55*$this->scale, $this->tilew/8*$this->scale, '0110','F');
		$this->RoundedRect($i+$this->tilew/2.75*$this->scale, $j+$this->tileh/2.75*$this->scale, $this->tilew/1.55*$this->scale, $this->tileh/4*$this->scale, $this->tilew/8*$this->scale, '0011','F');
	}
	function helpcard3($i,$j){
		$this->SetFont('helvetica', '', 15);
		$this->Text($i,$j, '3');
		$i = $i + 6;
		$this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$this->SetFillColor(155, 155, 155);
		$this->RoundedRect($i, $j, $this->tilew*$this->scale, $this->tileh*$this->scale, $this->tilew/8, '1111', 'F');
		$this->SetFillColor(255, 255, 255);
		$this->RoundedRect($i+$this->tilew/2.75*$this->scale, $j+$this->tileh/2.75*$this->scale, $this->tilew/4*$this->scale, $this->tileh/1.55*$this->scale, $this->tilew/8*$this->scale, '1001','F');
		$this->RoundedRect($i+$this->tilew/2.75*$this->scale, $j+$this->tileh/2.75*$this->scale, $this->tilew/1.55*$this->scale, $this->tileh/4*$this->scale, $this->tilew/8*$this->scale, '0011','F');
	}
	function helpcard4($i,$j){
		$this->SetFont('helvetica', '', 15);
		$this->Text($i,$j, '4');
		$i = $i + 6;
		$this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$this->SetFillColor(155, 155, 155);
		$this->RoundedRect($i, $j, $this->tilew*$this->scale, $this->tileh*$this->scale, $this->tilew/8, '1111', 'F');
		$this->SetFillColor(255, 255, 255);
		$this->RoundedRect($i+$this->tilew/2.75*$this->scale, $j+$this->tileh/2.75*$this->scale, $this->tilew/4*$this->scale, $this->tileh/1.55*$this->scale, $this->tilew/8*$this->scale, '1001','F');
		$this->RoundedRect($i-1, $j+$this->tileh/2.75*$this->scale, $this->tilew/1.55*$this->scale, $this->tileh/4*$this->scale, $this->tilew/8*$this->scale, '1100','F');
	}
	function helpcard5($i,$j){
		$this->SetFont('helvetica', '', 15);
		$this->Text($i,$j, '5');
		$i = $i + 6;
		$this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$this->SetFillColor(155, 155, 155);
		$this->RoundedRect($i, $j, $this->tilew*$this->scale, $this->tileh*$this->scale, $this->tilew/8, '1111', 'F');
		$this->SetFillColor(255, 255, 255);
		
		$this->RoundedRect($i, $j+$this->tileh/2.75*$this->scale, $this->tilew/1*$this->scale, $this->tileh/4*$this->scale, $this->tilew/8*$this->scale, '0000','F');
	}
	function helpcard6($i,$j){
		$this->SetFont('helvetica', '', 15);
		$this->Text($i,$j, '6');
		$i = $i + 6;
		$this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$this->SetFillColor(155, 155, 155);
		$this->RoundedRect($i, $j, $this->tilew*$this->scale, $this->tileh*$this->scale, $this->tilew/8, '1111', 'F');
		$this->SetFillColor(255, 255, 255);
		$this->RoundedRect($i+$this->tilew/2.75*$this->scale, $j, $this->tilew/4*$this->scale, $this->tileh/1*$this->scale, $this->tilew/8*$this->scale, '0000','F');
		
	}
}

// create new PDF document
//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$orientation = 'L'; //Landscape
$pdf = new MYPDF($orientation, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Rodrigo Caruso');
$pdf->SetTitle('Avenue');
$pdf->SetSubject('');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetHeaderMargin(500);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// add a page
$pdf->AddPage();

$mapA = array(
			array('oovo','v','A','oo','','O'),
			array('v','oo','o','v','oov',''),
			array('o','','vvo','B','o','oo'),
			array('C','vv','oo','','vv','D'),
			array('vv','','E','v','oov','v'),
			array('','vvo','o','vv','o',''),
			array('V','o','v','F','','vvvo')
		); //24o 24v
$mapB = array(
			array('ooov','','vo','A','','oov'),
			array('o','B','v','','vv','o'),
			array('ov','v','o','oo','v','O'),
			array('','C','vv','','D','vv'),
			array('V','o','v','oov','o','oo'),
			array('ov','oo','','v','E','v'),
			array('vvo','v','F','','o','vovv')
		);
$mapC = array(
			array('A','vv','','V','oo','vv'),
			array('o','','vovv','vo','v','B'),
			array('v','C','v','o','o',''),
			array('oov','','v','oov','v','vv'),
			array('','v','vvo','o','D','oo'),
			array('E','ov','o','ooov','','o'),
			array('oo','v','O','','ov','F')
		);
		
$type = ''; $map = null;
if(isset($_GET['type'])) $type = substr($_GET['type'],0,8);
$debug = false;

if(isset($_GET['debug'])) define("DEBUG", true);
else define("DEBUG", false);

set_time_limit ( 10 ); //Seconds to script timeout

/*
//disabled maps as politelly asked as a favor by brazilian Papergames game publisher

if(strtoupper($type)=='DISABLEA')$map=$mapA;
else if(strtoupper($type)=='DISABLEB')$map=$mapB;
else if(strtoupper($type)=='DISABLEC')$map=$mapC;
*/
if(false){} //disabled
	
else{
	//creates a initial seed based on txt from $type that is the typed word
	$chars = str_split($type); $seed = 0; $cont = 1.0;
	foreach($chars as $char){
	    $seed += ord($char) * $cont;
	    $cont+=0.3;
	}
	$seed=round($seed);
	srand($seed);
	$map = false;
	$contmap = 0;
	while($map == false){
        $map = generatemap();
        if($contmap > 1000) { echo "Too many retries"; return;}
        $contmap++;
	}
}


if($orientation == 'L'){
	//Landscape mode
	$pdf->starti = 40;
	$pdf->startj = 13.5;
	$pdf->Sheet($map,$type);

	$pdf->starti = 40;
	$pdf->startj = 107.5;
	$pdf->Sheet($map,$type);

	$pdf->starti = 169;
	$pdf->startj = 13.5;
	$pdf->Sheet($map,$type);
	
	$pdf->starti = 169;
	$pdf->startj = 107.5;
	$pdf->Sheet($map,$type);
}
else{
	//Portrait mode
	$pdf->starti = 35;
	$pdf->startj = 5;
	$pdf->Sheet($map,$type);

	$pdf->starti = 35;
	$pdf->startj = 99;
	$pdf->Sheet($map,$type);
	
	$pdf->starti = 35;
	$pdf->startj = 193;
	$pdf->Sheet($map,$type);
}


function &generatemap(){
	$mp = 
		array(
			array('','','','','',''),
			array('','','','','',''),
			array('','','','','',''),
			array('','','','','',''),
			array('','','','','',''),
			array('','','','','',''),
			array('','','','','','')
		);
		
	buildVOcastles($mp); //Builds 'V' and 'O' castles first on the matrix squares
	if(DEBUG){ print"<pre>";print_r($mp);print"</pre>"; }
	
	//Tries to put the farms on valid positions (letters A-F)
	if(! farmbuild($mp, 'A') ) return false;
	if(! farmbuild($mp, 'B') ) return false;
	if(! farmbuild($mp, 'C') ) return false;
	if(! farmbuild($mp, 'D') ) return false;
	if(! farmbuild($mp, 'E') ) return false;
	if(! farmbuild($mp, 'F') ) return false;
	
	//shos the matrix if in debug mode
	if(DEBUG){ print"<pre>";print_r($mp);print"</pre>"; }
	
	//adds 48 grapes, 24 interactions dropping 1 grape of each type ("v"/"o") each loop 
	for($kadd =0; $kadd < 24; $kadd++){
		add($mp, 'v');
		add($mp, 'o');
	}
	
	//print"<pre>";print_r($mp);print"</pre>";
	return $mp;
}
function buildVOcastles(&$mp){
	//Puts the two castles V and O (uppercase) on opposite sides like the original maps
	$i = 0; $j = 0;
	
	//randomly decides if V or O goes first
	if(rand(0, 1) == 0){
        $firstletter = 'V';
        $secondletter = 'O';
	}
	else{
        $firstletter = 'O';
        $secondletter = 'V';
	}
	if(DEBUG) echo "$firstletter left and $secondletter right";
	
	//Decides if the castles are disposed one left other right, or if they are one at top and one botton
	//Then it randomizes the their exact position in that row/column
	if(rand(0, 1) == 0){
        $jfirst = rand(0, 6);
        $mp[$jfirst][0] = $firstletter;
        do{
            $j = rand(0, 6);
        }while($j == $jfirst);
        $mp[$j][5] = $secondletter;
    }
	else{
        $ifirst = rand(0, 5);
        $mp[0][$ifirst] = $firstletter;
        do{
            $i = rand(0, 5);
        }while($i == $ifirst);
        $mp[6][$i] = $secondletter;
	}
}
function farmbuild(&$mp, $letter){
	//builds a farm
    if(DEBUG) echo "$letter<BR>";
	$i = 0; $j = 0; $cont = 0;
	do{
		//loops while it does not find a valid spot for the farm, with no neighbors
        if($cont > 1000) return false; //Fails if tries to find a valid a farm spot(maybe it is impossible with current alocations)
		$i = rand(0, 5);
		$j = rand(0, 6);
		$cont++;
	}while(!checkfarmbuild($mp,$i,$j));
	$mp[$j][$i] = $letter; //puts the farm on the matrix "square"
	return true;
}
function checkfarmbuild(&$mp, $i,$j){
    //Checks if the drawn position does not have neighboring ABCDEF
    //If some neighbor square is already occupied it returns false, else return true
    
	//echo "Checking (j $j, i $i);<br>";
	//echo "Counts (j ".count($mp).",i ".count($mp[0]).");<br>";
	if(DEBUG) echo 'origin $mp[j ' . ($j) . "][i " . ($i) . "]<br>";
	$errors = 0;
	
	//check if not empty
	if($mp[$j][$i] != ''){
		return false;
	}
	
	//top
	if($j!=0){
		//echo 'top $mp[j ' . ($j-1) . "][i " . $i . "]<br>";
		if($mp[$j-1][$i] != '' && strpos('ABCDEFVO' , $mp[$j-1][$i]) !== FALSE){
			return false;
		}
	}
	//right
	if($i!=5){
		//echo 'right $mp[j ' . $j . "][i ". ($i + 1) . "]<br>";
		if($mp[$j][$i+1] != '' &&strpos('ABCDEFVO' , $mp[$j][$i+1]) !== FALSE){
			return false;
		}
	}
	//botton
	if($j!=6){
		//echo 'botton $mp[j '. ($j + 1) . '][i ' . $i . "]<br>";
		if($mp[$j+1][$i] != '' &&strpos('ABCDEFVO' , $mp[$j+1][$i]) !== FALSE){
			return false;
		}
	}
	//left
	if($i!=0){
		//echo 'left $mp[j ' . $j . '][i ' . ($i - 1) . ']<br>';
		if($mp[$j][$i-1] != '' &&strpos('ABCDEFVO' , $mp[$j][$i-1]) !== FALSE){
			return false;
		}
	}
	//topleft
	if(DEBUG) echo "topleft1 $j,$i - (" . ($j!=0) . ") && (" . ($i!=0) . ")";
	if($j!=0 && $i!=0){
        if(DEBUG) echo "topleft2: ".$mp[$j-1][$i-1]."=".$mp[$j-1][$i-1];
		if($mp[$j-1][$i-1] != '' && strpos('ABCDEFVO' , $mp[$j-1][$i-1]) !== FALSE){
            if(DEBUG) echo 'topleft neigbor $mp[j ' . ($j-1) . "][i " . ($i-1) . "]<br>";
			return false;
		}
	}
	//topright
	if($j!=0 && $i!=5){
		if($mp[$j-1][$i+1] != '' && strpos('ABCDEFVO' , $mp[$j-1][$i+1]) !== FALSE){
            if(DEBUG) echo 'topright neigbor $mp[j ' . ($j-1) . "][i " . ($i+1) . "]<br>";
			return false;
		}
	}
	//bottonright
	if($j!=6 && $i!=5){
		if($mp[$j+1][$i+1] != '' && strpos('ABCDEFVO' , $mp[$j+1][$i+1]) !== FALSE){
            if(DEBUG) echo 'bottonright neigbor $mp[j ' . ($j+1) . "][i " . ($i+1) . "]<br>";
			return false;
		}
	}
	//bottonleft
	if($j!=6 && $i!=0){
		if($mp[$j+1][$i-1] != '' && strpos('ABCDEFVO' , $mp[$j+1][$i-1]) !== FALSE){
            if(DEBUG) echo 'bottonleft neigbor $mp[j ' . ($j+1) . "][i " . ($i-1) . "]<br>";
			return false;
		}
	}
	return true;
}

function add(&$mp, $letter){
	//add a letter to a sheet
	$i = 0; $j = 0;
	
	do{
		//gets random position while it chooses invalid positions
		//when it gets a valid position, it stops
		$i = rand(0, 5);
		$j = rand(0, 6);	
	}while(!checkadd($mp,$i,$j));
	
	//Puts the v(triangles) on the right and circles on the left
	if($letter == 'v'){
		//triangles on the right
		$mp[$j][$i] = $mp[$j][$i] . $letter;
	}
	else{
		//circles on the left
		$mp[$j][$i] = $letter . $mp[$j][$i];
	}
}
function checkadd(&$mp, $i, $j){
	//checks and inform if the position is invalid
	if(strlen($mp[$j][$i]) == 0){
		//if the square is empty, it is valid
		return true;
	}
	else if(strlen($mp[$j][$i]) == 1 && $mp[$j][$i] != 'v' && $mp[$j][$i] != 'o'){
		//if square is not empty, and occupied by something different than grapes 
		// it means that it is coccupied by a Farm or castle so it is invalid
		return false;
	}
	else if(strlen($mp[$j][$i]) <= 3){
		if(rand(0, 2) == 1){
			//two thirds of the time it avoids generating in already occupied spaces, so it have a tendency to spread more the grapes
			return false;
		}
		else{
			//this puts the grape in a square with 1-3 grapes already
			return true;
		}
	}
	else{
		return false;
	}
}

// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('Avegen_seed-'.$type.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
