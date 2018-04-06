<?php
include "../dbms/getList.php";
//variables for fee receipt
$costLabelMatrix = array();
$recMatrix = array();

function array_push_assoc($array, $key, $value) {
    $array[$key] = $value;
    return $array;
}

if (isset($_POST['submitStd'])) {
    $_SESSION["std"] = $_POST['std'];
}

if (isset($_POST['custom'])) {
    
    $_SESSION["sname"] = $_POST['nestudent'];
    $_SESSION["fname"] = $_POST['nefather'];
    $_SESSION['sr'] = "N/A";
    
}

if (isset($_POST['submitStudentDetails'])) {    
    separateDetails($_POST['sDetails']);
}

if (isset($_POST['chequeDetails'])) {
    //echo "Now is next";
    if(trim($_POST['bank'])){
        $_SESSION['bank'] = $_POST['bank'];
    $_SESSION['chequeDate'] = $_POST['chequeDate'];
    $_SESSION['chequeNumber'] = $_POST['chequeNumber'];
        $_SESSION["cash"] = "n";
    }
    //echo $_SESSION['chequeDate'];
}

if (isset($_POST['cash'])) {
    $_SESSION["cash"] = "y";
}

if (isset($_POST['issueRec'])) {
    for ($i = 1; $i <= ($_SESSION['countLabels']); $i++) {
        $tempArray = array("$i" => "$_POST[$i]");
        $tempName = $i . "templates";
        $costLabelMatrix = array_push_assoc($costLabelMatrix, "$_SESSION[$tempName]", "$_POST[$i]");
    }
   // print_r($costLabelMatrix);
   // echo "<html><br></html>";

    //getting effective labels containing positive amount
    foreach ($costLabelMatrix as $eachLabel => $eachCost) {
        if ($eachCost > 0) {
            //  $tempArray = array("$_SESSION[$i]"=>"$_POST[$i]");
            $recMatrix = array_push_assoc($recMatrix, "$eachLabel", "$eachCost");
        }
    }
    //print_r($recMatrix);
  //  echo "END";

    //getting manual effective labels containing positive amount
    for ($i = $_SESSION['countLabels'] + 1; $i <= ($_SESSION['countLabels'] + $_SESSION['manualLabels']); $i++) {
        if ($_POST[$i] > 0) {
            $manualLabelName = $i + 100;
            //$manualLabelName .="";
            $recMatrix = array_push_assoc($recMatrix, "$_POST[$manualLabelName]", "$_POST[$i]");
        }
    }
   // echo "<html><br></html>";
   // print_r($recMatrix);
    //echo "<html><br></html>";
    //echo sizeof($recMatrix);

    //saving receipt information in the session file
    $_SESSION["receiptData"] = $recMatrix;
    issueRec($recMatrix);




    /*
      for($i=$countLabels;$i<($countLabels+$manualLabels);$i++){
      $tempArray = array("$i"=>"$_POST[$i]");
      $costLabelMatrix= array_merge($costLabelMatrix,$tempArray);
      } */
}

//header("Location: http://www.yourwebsite.com/user.php");
//exit();
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <title>Fee Wizard | Tech-Rex</title>
    </head>

    <body>
        <header>
            <div class="row bg-danger p-3 ">
                <h4 class="col-8 text-white text-uppercase font-weight-bold">tech-rex server 1.0 - Fee Wizard</h4>
                <h5 class="col text-light text-right text-capitalize font-italic">welcome creator-JVM - tech.@override -<BR> JRL COMMAND LINE - ACCESS OVERRIDE</h5>
            </div>        
            <!-- NAVBAR WITH RESPONSIVE TOGGLE -->
            <nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-3">
                <div class="container">
                    <a class="navbar-brand" href="#">Operations</a>
                    <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Issue</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="historyFeeRec.php">History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Customise</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Templates</a>
                            </li>
                        </ul>
                        <form action="" class="form-inline my-2">
                            <input type="text" class="form-control" placeholder="Enter S.R.">
                            <button type="button" class="btn my-2 mr-sm-2 btn-outline-success ">Search</button>
                        </form>
                    </div>
                </div>
            </nav>
        </header>


        <!-- SELECTION OF CHILD --> 
        <div class="container">
            <form action='feeCentral.php' method="post">
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="std">Standard</label>
                        <div class="input-group">                    
                            <select name="std" class="form-control">
                                <?php
                                getStd();
                                while ($std = mysqli_fetch_row($resultStd)) {
                                    //echo "<option value='$std[0]'>$std[0]</option>";
                                    
                                    //to hold down the selected drop-down item
                                    if(isset($_POST['submitStd'])){     //to check if something is selected
                                        $st = $_POST['std'];
                                        if($st==$std[0]){
                                            echo "<option value='$std[0]' selected='$st'>$std[0]</option>";
                                        }
                                        else {
                                            echo "<option value='$std[0]'>$std[0]</option>";
                                        }                                      
                                    }
                                    else {
                                      echo "<option value='$std[0]'>$std[0]</option>";
                                    }
                                    
                                    
                                }
                                ?> 
                            </select>
                            <div class="input-group-btn">
                                <button type='submit' name="submitStd" class="btn btn-primary">View</button>
                            </div>
                        </div>
                    </div>  


                    <div class="form-group col-sm ">
                        <label for="std">Student's Name</label>
                        <div class="input-group">
                            <select name="sDetails" class="form-control">
                                <?php
                                getStudent($_POST['std']);
                                while ($std = mysqli_fetch_row($resultStd)) {
                                    $detailsTemplate = $std[0]."_s_".$std[1]."_s_".$std[2];
                                   // echo "<option value='$detailsTemplate'>$std[0]_____$std[1]_____$std[2]</option>";
                                    
                                    //to hold down the selected drop-down item
                                    if(isset($_POST['submitStudentDetails'])){     //to check if something is selected
                                        $sdnt = $_POST['sDetails'];
                                        if($sdnt==$detailsTemplate){
                                            echo "<option value='$std[0]' selected='$sdnt'>$sdnt</option>";
                                        }
                                        else {
                                           echo "<option value='$detailsTemplate'>$std[0]_____$std[1]_____$std[2]</option>";
                                        }                                      
                                    }
                                    else {
                                      echo "<option value='$detailsTemplate'>$std[0]_____$std[1]_____$std[2]</option>";
                                    }
                                    
                                    
                                }
                                ?> 
                            </select>  
                            <div class="input-group-btn">
                                <button type='submit' name="submitStudentDetails" class="btn btn-primary">Select</button>
                            </div>
                        </div>                        
                    </div>

                    <!-- <div class="form-group col-sm-4">
                        <label for="std">Father's Name</label>
                        <input type="text" class="form-control" >
                    </div> -->

                </div>           
            </form>
        </div> 

        <!-- cheque Details -->
        <div class="container">
            <form action="feeCentral.php" method="post" class="form-group col-sm ">
                <div class="input-group formcontrol">
                    <div class="row">
                        <div class="col input-group ">
                            <label class="input-group-addon">Bank Name</label>
                            <input class="form-control" name='bank' type="text" placeholder="Bank Name">
                        </div>
                        <div class="col input-group ">
                            <label class="input-group-addon">C. Date</label>
                            <input class="form-control" name='chequeDate' type="date" placeholder="Date">
                        </div>
                        <div class="col input-group ">
                            <label class="input-group-addon">C. Number</label>
                            <input class="form-control" name='chequeNumber' type="number" placeholder="Number">
                        </div>
                        <input type="submit" class="sm btn btn-primary" name="chequeDetails" value="Cheque">
                        <input type="submit" class="sm ml-2 btn btn-success" name="cash" value="Cash">
                    </div>                
                </div>
            </form>
        </div>



        <!-- FEE DETAILS-->
        <div class="container">
            <div class="row bg-primary">
                <div class="col-sm-8 bg-light">
                    <form action='feeCentral.php' method="post">
                        <table class="table table-hover table-striped table-bordered">
                            <thead class="thead-inverse">
                                <tr class="">
                                    <th class="text-center">PARTICULAR (S)</th>
                                    <th class="text-center">AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $resultStd = getLabels();
                                global $countLabels; //Remember that 5 labels extra have to be added for manual entry
                                $_SESSION['manualLabels'] = 5;
                                while ($labels = mysqli_fetch_row($resultStd)) {
                                    $countLabels++;
                                    echo "<tr>"
                                    . "<td>$labels[1]"
                                    . "</td>";
                                    echo "<td class='text-center'>"
                                    . "<input type='text' class='m-auto text-center form-control' name='$labels[0]' style='width:50%;' placeholder='Amount'>"
                                    . "</td>";
                                    $_SESSION[$labels[0] . "templates"] = "$labels[1]"; //added                                    
                                }
                                $_SESSION['countLabels'] = $countLabels;

//Manual entry rows in the table
                                for ($i = $_SESSION['countLabels'] + 1; $i <= ($_SESSION['countLabels'] + $_SESSION['manualLabels']); $i++) {
                                    $iForLabel = $i + 100;
                                    echo "<tr>"
                                    . "<td><input type='text' class='form-control' placeholder='Particular' name='$iForLabel'></input>"
                                    . "</td>";
                                    echo "<td class='text-center'>"
                                    . "<input type='text' class='m-auto text-center form-control' name='$i' style='width:50%;' placeholder='Amount'>"
                                    . "</td>";
                                }
                                ?>

                                <!--  same thing has been entered into php above -->
<!--                            <tr>
                                    <td >Life</td>
                                    <td class="text-center"><input type="text" class="m-auto text-center form-control" style="width:50%;" placeholder="Amount"></td>
                                </tr>-->

                            </tbody>
                        </table>                        
                        <input type="submit" class="btn btn-block btn-outline-success" name="issueRec">
                    </form>
                </div>
                
                
                <div class="col-sm-4 bg-light"> 
                    <form action="feeCentral.php" method="post">
                        <div class="d-flex flex-row">                        
                        <div class="input-group ">
                            <label class="input-group-addon">Student's Name</label>
                            <input class="form-control mr-2" type="text" name = "nestudent" placeholder="unenrolled student">
                        </div></div>
                    <div class="d-flex flex-row">
                        <div class="input-group mt-1 ">
                            <label class="input-group-addon">Father's Name</label>
                            <input class="form-control" type="text" name="nefather" placeholder="unenrolled father">
                        </div>
                    </div> 
                        <input type="submit" class=" mt-1 btn btn-block btn-info" name="custom" value='Customise'>
                    </form>
                                          
                    
                </div>
                
                
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    </body>
</html>
<?php ?>