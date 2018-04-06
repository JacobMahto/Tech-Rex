<?php
session_start();
include "connectDbms.php";
$resultStd = 5;

//setting server time
date_default_timezone_set('Asia/Calcutta');
$dateByCalcutta = date('d/m/Y');

//// A user-defined error handler function
//function myErrorHandler($errno, $errstr, $errfile, $errline) {
//    //echo "<b>Custom error:</b> [$errno] $errstr<br>";
//    //echo " Error on line $errline in $errfile<br>";
//    if ($errno === 8) {
//        die("<html><script>alert('helloddd');</script></html>");
//    }
//}
//
//// Set user-defined error handler function
//set_error_handler("myErrorHandler");

//check system notice
function checkNotice(){
    
}

//get list of available classes
function getStd() {
    global $resultStd;
    global $connection;
    $query = "SELECT * FROM std;";
    $resultStd = mysqli_query($connection, $query);
}

//get list of students belonging to specified class
function getStudent($std) {
    global $resultStd;
    global $connection;
    $query = "SELECT name,fname,sr FROM studentinfo where class='$std';";
    $resultStd = mysqli_query($connection, $query);
}

//get labels(or templates) for fee receipt
function getLabels() {
    global $connection;
    global $resultStd;
    $query = "SELECT sn,name FROM labels;";
    $resultStd = mysqli_query($connection, $query);
    return $resultStd;//^^^^^^^^^
}

//separate details from details template containing sname , fname and sr containing _s_ marker.
function separateDetails($str) {
    //let $contains sname_s_fname_s_sr
    $ind1 = stripos($str, "_s_");
    $ind2 = strripos(($str), "_s_");

    $_SESSION["sname"] = substr($str, 0, $ind1);
    $_SESSION["fname"] = substr($str, $ind1 + 3, $ind2 - ($ind1 + 3));
    $_SESSION["sr"] = substr($str, $ind2 + 3);
//    echo $_SESSION["sname"];
//    echo "<html><br></html>";
//    echo $_SESSION["fname"];
//    echo "<html><br></html>";
//    echo $_SESSION["sr"];
}

//issue receipt from associative array
function issueRec($labelCostMatrix) {
    global $connection;
    $status = checkSessionExist();
    if($status == 'stop'){
      //  session_destroy();
        echo "<html><script>alert('INSUFFICIENT DATA. TRY AGAIN.');</script></html>";
        //sleep(5);
        header( "refresh:0.02; url=../fee/feeCentral.php" );
       //header( 'Location: ../fee/feeCentral.php' );
      //   exit('');
        
       //exit('failed');  
    }
    else {
        if ($_SESSION['cash'] == 'y') {
        $_SESSION['bank'] = '';
        $_SESSION['chequeDate'] = '';
        $_SESSION['chequeNumber'] = '';
    } else {
        $_SESSION['chequeDate'] = correctDate($_SESSION['chequeDate']);
        
    }

    $insertQuery = "INSERT INTO recdata VALUES(null , '";
    global $dateByCalcutta;
    $insertQuery .= $_SESSION["sname"] . "','";
    $insertQuery .= $_SESSION["fname"] . "','";
    $insertQuery .= $_SESSION["sr"] . "','";
    $insertQuery .= $_SESSION["std"] . "','";
    $insertQuery .= $dateByCalcutta."',";
    $insertQuery .= array_sum($labelCostMatrix) . ",'" . $_SESSION['bank'] . "','" .$_SESSION["chequeDate"]  . "','" . $_SESSION['chequeNumber'] . "',";
    $insertQuery .= convertCostLabelToQuery($labelCostMatrix);
    $insertQuery .= "'CNF');";

   // echo "<html><br><b>" . $insertQuery . "</b><br></html>";
    $resultStd = mysqli_query($connection, $insertQuery);
    if ($resultStd) {
        echo "<html><script>alert('SUCCESS. RECEIPT ISSUED.');</script></html>";
        $lastRec = getLastRecNo();
        session_unset();
        session_destroy();
        //header( 'Location: ../fee/feeCentral.php' );
        
        //echo "<script>window.location = '../fee/feeCentral.php';</script>";
        
        openLinkInNewTab($lastRec);
        
        
    } else {
        echo "<html><script>alert('FAILED. NOT ISSUED.');</script></html>";
    }
    
    
    }
    
    
}

function getLastRecNo(){
    global $dbName;
    global $connection;
    $query = "SELECT `AUTO_INCREMENT`
FROM  INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = '$dbName'
AND   TABLE_NAME   = 'recdata';";
    $result = mysqli_query($connection, $query);
    $recTemp = mysqli_fetch_row($result);
    $recNo = $recTemp[0] - 1;
    return $recNo;
}
function openLinkInNewTab($recNo){
    
    echo "<script>

    window.onload = function(){
         var rec = window.open('../fee/invoice.php?a=$recNo', '_blank'); // will open new tab on window.onload
             rec.focus();
    }    
    
</script>";
    
}


function checkSessionExist(){
    $check1 = $_SESSION['cash'];
    $check2 = $_SESSION['sname'];
    $check3 = $_SESSION['sr'];
    if(trim($check1)=='' || trim($check2)=='' || trim($check3)=='') {
         
    session_unset();
    return 'stop';
}
    return 'cont';
}

function convertCostLabelToQuery($labelCostMatrix) {
    $convertedQuery = "";
    $arrayLength = count($labelCostMatrix);
    $count = 0;
    foreach ($labelCostMatrix as $key => $cost) {
        $count++;
        if ($count != $arrayLength) {
            $convertedQuery .= "'$key','" . "$cost',";
        } else {
            $convertedQuery .= "'$key','" . "$cost',";
        }
    }
    $temp_array_length = $arrayLength * 2;
    //echo "jkjk" . $arrayLength . "klklkl";
    for ($j = $temp_array_length + 1; $j <= 24; $j++) {
        $convertedQuery .= "null,";
    }
    return $convertedQuery;
}

function getRecDataAssociativeArray($recNo){
    global $connection;
    $query = "SELECT * FROM recdata where recno = '$recNo'";
    $result = mysqli_query($connection, $query);
    $ans = mysqli_fetch_assoc($result);
    return $ans;
    //print_r($ans);
}

function getRecDataByIndex($recNo){
    global $connection;
    $query = "SELECT * FROM recdata where recno = '$recNo'";
    $result = mysqli_query($connection, $query);
    $ans = mysqli_fetch_row($result);
    return $ans;
    //print_r($ans);
}

function stdToWord($std){
    if(trim($std)=='I'){
        $std .=" (First)";
    }
    else if(trim($std)=='II'){
        $std .=" (Second)";
    }
    else if(trim($std)=='III'){
        $std .=" (Third)";
    }
    else if(trim($std)=='IV'){
        $std .=" (Fourth)";
    }
    else if(trim($std)=='V'){
        $std .=" (Fifth)";
    }
    else if(trim($std)=='VI'){
        $std .=" (Sixth)";
    }
    else if(trim($std)=='VII'){
        $std .=" (Seventh)";
    }
    else if(trim($std)=='VIII'){
        $std .=" (Eighth)";
    }
    else if(trim($std)=='IX'){
        $std .=" (Ninth)";
    }
    else if(trim($std)=='X'){
        $std .=" (Tenth)";
    }
    else if(trim($std)=='PG'){
        $std .=" (Playgroup)";
    }
    else {
        
    }
    return $std;
    
}

function correctDate($str){  
$str = date_create($str);
$str = date_format($str, 'd/m/Y');
return $str;
}

function convertNumberToWord($num = false)
{
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words);
}
?>