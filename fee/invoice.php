<?php

include '../dbms/getList.php';
$recNo = $_GET['a'];
//echo "aaaaa".$recNo;
$ans = getRecDataAssociativeArray($recNo);
$ansByIndex = getRecDataByIndex($recNo);
$lateralShift = 147;


//require_once('tcpdf/tcpdf.php');
//require_once('fpdi2/src/autoload.php'); 
?>
<?php

use setasign\Fpdi\Fpdi;

require_once('fpdf/fpdf.php');
require_once('fpdi2/src/autoload.php');

// initiate FPDI
$pdf = new Fpdi();
// add a page
$pdf->AddPage();

if (!trim($ans['chekno']) || !trim($ans['chekdate']) || !trim($ans['bank'])){
    $pdf->setSourceFile('recCashTemp.pdf');
}
else {
    // set the source file
$pdf->setSourceFile('recTemp.pdf');
}

// import page 1
$tplIdx = $pdf->importPage(1);
// use the imported page and place it at position 10,10 with a width of 100 mm
$pdf->useTemplate($tplIdx);

// now write some text above the imported page
$pdf->SetFont('times', '', 12);
$pdf->SetFontSize(12);

$pdf->SetTextColor(0, 0, 0);

//setting receipt no
$pdf->SetXY(38, 43.7);
$pdf->Write(0, $ans['recno']);
$pdf->SetXY(38, 43.7 + $lateralShift);
$pdf->Write(0, $ans['recno']);


//setting date
$pdf->SetXY(156, 43.7);
$pdf->Write(0, $ans['date']);
$pdf->SetXY(156, 43.7 + $lateralShift);
$pdf->Write(0, $ans['date']);

//setting sname
$pdf->SetXY(46, 51);
$pdf->Write(0, $ans['sname']);
$pdf->SetXY(46, 51 + $lateralShift);
$pdf->Write(0, $ans['sname']);



//setting standard
$pdf->SetXY(154, 51);
$pdf->Write(0, stdToWord($ans['std']));
$pdf->SetXY(154, 51 + $lateralShift);
$pdf->Write(0, stdToWord($ans['std']));


//setting fname
$pdf->SetXY(44, 58.4);
$pdf->Write(0, $ans['fname']);
$pdf->SetXY(44, 58.4 + $lateralShift);
$pdf->Write(0, $ans['fname']);

//setting total in words
$pdf->SetXY(47, 118);
$pdf->Write(0, ucwords(convertNumberToWord($ans['total']) . "Rupees Only."));
$pdf->SetXY(47, 118 + $lateralShift);
$pdf->Write(0, ucwords(convertNumberToWord($ans['total']) . "Rupees Only."));

//setting total in numbers
$pdf->SetXY(175, 111);
$pdf->Write(0, number_format($ans['total'],2));
$pdf->SetXY(175, 111 + $lateralShift);
$pdf->Write(0, number_format($ans['total'],2));



//setting bank name
$pdf->SetXY(37, 125.5);
if(strlen($ans['bank'])>20){
    $pdf->SetFontSize(9);
}
$pdf->Write(0, $ans['bank']);//max letter count is 27 ,else it will overlap with cheque date , hence ,the if block
$pdf->SetXY(37, 125.5 + $lateralShift);
$pdf->Write(0, $ans['bank']);
//resetting font size
$pdf->SetFontSize(12);

//setting cheque date
$pdf->SetXY(119, 125.5);
$pdf->Write(0, $ans['chekdate']);
$pdf->SetXY(119, 125.5 + $lateralShift);
$pdf->Write(0, $ans['chekdate']);

//setting cheque no
$pdf->SetXY(177, 125.5);
$pdf->Write(0, $ans['chekno']);
$pdf->SetXY(177, 125.5 + $lateralShift);
$pdf->Write(0, $ans['chekno']);


//setting fee details
$count = 0;
$address = array();
for ($i = 10; $i <= 32; $i = $i + 2) {
    if (trim($ansByIndex[$i])) {
        if ($ansByIndex[$i + 1] > 0) {
            array_push($address, $ansByIndex[$i], $ansByIndex[$i + 1]);
            $count++;
        }
    }
}

//--
if ($count == 5) {
    $lbl = 0; //label
    $yshift = 0;
    for ($iterate = 1; $iterate <= $count; $iterate++) {
        //setting serial no
        $pdf->SetXY(16, 75 + $yshift);
        $pdf->Write(0, $iterate);
        $pdf->SetXY(16, 75 + $yshift + $lateralShift);
        $pdf->Write(0, $iterate);
//setting label
        $pdf->SetXY(26, 75 + $yshift);
        $pdf->Write(0, $address[$lbl]);
        $pdf->SetXY(26, 75 + $yshift + $lateralShift);
        $pdf->Write(0, $address[$lbl]);
//setting cost
        $tempCost = number_format($address[$lbl + 1], 2);
        $pdf->SetXY(175, 75 + $yshift);
        $pdf->Write(0, $tempCost);
        $pdf->SetXY(175, 75 + $yshift + $lateralShift);
        $pdf->Write(0, $tempCost);
//updation
        $yshift += 7;
        $lbl += 2;
    }
}

if ($count < 5) {
    $lbl = 0; //label
    $yshift = 0;
    for ($iterate = 1; $iterate <= $count; $iterate++) {
        //setting serial no
        $pdf->SetXY(16, 75 + $yshift);
        $pdf->Write(0, $iterate);
        $pdf->SetXY(16, 75 + $yshift + $lateralShift);
        $pdf->Write(0, $iterate);
//setting label
        $pdf->SetXY(26, 75 + $yshift);
        $pdf->Write(0, $address[$lbl]);
        $pdf->SetXY(26, 75 + $yshift + $lateralShift);
        $pdf->Write(0, $address[$lbl]);
//setting cost
        $tempCost = number_format($address[$lbl + 1], 2);
        $pdf->SetXY(175, 75 + $yshift);
        $pdf->Write(0, $tempCost);
        $pdf->SetXY(175, 75 + $yshift + $lateralShift);
        $pdf->Write(0, $tempCost);
//updation
        $yshift += 10;
        $lbl += 2;
    }
}


if ($count > 5 && $count <= 7) {
    $lbl = 0; //label
    $yshift = 0;
    for ($iterate = 1; $iterate <= $count; $iterate++) {
        //setting serial no
        $pdf->SetXY(16, 75 + $yshift);
        $pdf->Write(0, $iterate);
        $pdf->SetXY(16, 75 + $yshift + $lateralShift);
        $pdf->Write(0, $iterate);
//setting label
        $pdf->SetXY(26, 75 + $yshift);
        $pdf->Write(0, $address[$lbl]);
        $pdf->SetXY(26, 75 + $yshift + $lateralShift);
        $pdf->Write(0, $address[$lbl]);
//setting cost
        $tempCost = number_format($address[$lbl + 1], 2);
        $pdf->SetXY(175, 75 + $yshift);
        $pdf->Write(0, $tempCost);
        $pdf->SetXY(175, 75 + $yshift + $lateralShift);
        $pdf->Write(0, $tempCost);
//updation
        $yshift += 5;
        $lbl += 2;
    }
}

if ($count > 7 && $count <= 9) {
    $lbl = 0; //label
    $yshift = 0;
    for ($iterate = 1; $iterate <= $count; $iterate++) {
        //setting serial no
        $pdf->SetXY(16, 75 + $yshift);
        $pdf->Write(0, $iterate);
        $pdf->SetXY(16, 75 + $yshift + $lateralShift);
        $pdf->Write(0, $iterate);
//setting label
        $pdf->SetXY(26, 75 + $yshift);
        $pdf->Write(0, $address[$lbl]);
        $pdf->SetXY(26, 75 + $yshift + $lateralShift);
        $pdf->Write(0, $address[$lbl]);
//setting cost
        $tempCost = number_format($address[$lbl + 1], 2);
        $pdf->SetXY(175, 75 + $yshift);
        $pdf->Write(0, $tempCost);
        $pdf->SetXY(175, 75 + $yshift + $lateralShift);
        $pdf->Write(0, $tempCost);
//updation
        $yshift += 3.8;
        $lbl += 2;
    }
}

if ($count > 9 && $count <= 12) {
    $pdf->SetFontSize(8);
    $lbl = 0; //label
    $yshift = 0;
    for ($iterate = 1; $iterate <= $count; $iterate++) {
        //setting serial no
        $pdf->SetXY(16, 73 + $yshift);
        $pdf->Write(0, $iterate);
        $pdf->SetXY(16, 73 + $yshift + $lateralShift);
        $pdf->Write(0, $iterate);
//setting label
        $pdf->SetXY(26, 73 + $yshift);
        $pdf->Write(0, $address[$lbl]);
        $pdf->SetXY(26, 73 + $yshift + $lateralShift);
        $pdf->Write(0, $address[$lbl]);
//setting cost
        $tempCost = number_format($address[$lbl + 1], 2);
        $pdf->SetXY(175, 73 + $yshift);
        $pdf->Write(0, $tempCost);
        $pdf->SetXY(175, 73 + $yshift + $lateralShift);
        $pdf->Write(0, $tempCost);
//updation
        $yshift += 3;
        $lbl += 2;
    }

    //resetting size
    $pdf->SetFontSize(12);
}



//paid by cash
if (!trim($ans['chekno']) || !trim($ans['chekdate']) || !trim($ans['bank'])) {
//making font bold and underlined
    $pdf->SetFont('times', 'BU', 12);
    $pdf->SetFontSize(12);

    $pdf->SetXY(97, 125.5);
    $pdf->Write(0, 'BY CASH');
    $pdf->SetXY(97, 125.5 + $lateralShift);
    $pdf->Write(0, 'BY CASH');

//resetting fonts
    $pdf->SetFont('times', '', 12);
    $pdf->SetFontSize(12);
}

$pdf->Output();