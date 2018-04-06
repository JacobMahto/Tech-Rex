<?php
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
    <body class="bg-light">
        <?php
        // put your code here
        ?>
        <div class="container">
            <div class="row bg-info ">
                <p class="co-2 d-inline display-5 text-white">Tech-Rex Server</p>
                <p class="col-8 d-inline ml-auto font-weight-bold display-4 text-white">ISSUED RECEIPT</p>
                <p class="co-2 d-inline display-5 text-white">access : jvm</p>                
            </div>
            <table class="table table-hover table-striped">
                <thead>
                <th>Seq.</th>
                <th>
                    Rec. No.
                </th>
                <th>
                    S.R.
                </th>
                <th>
                    Date
                </th>                
                <th>
                    Student Name
                </th>
                <th>
                    Father Name
                </th>
                <th>
                    Class
                </th>    
                <th>
                    Payment
                </th> 
                </thead>
                <tbody>
                    <?php
                            include '../dbms/connectDbms.php';
                            $query = "select recno , sr , date , sname,fname, std,chekdate,bank from recdata;";
                            $resultStd = mysqli_query($connection, $query);      
                            $count = 0;
                                while ($receipt = mysqli_fetch_row($resultStd)) {
                                    $count++;
                                    echo "<tr>"
                                    . "<td>$count"
                                    . "</td>";
                                    echo '<td class="text-center text-black font-weight-bold"><a href="invoice.php/?a='.$receipt[0].'">'
                                    . $receipt[0]."</a></td>";
                                            
                                    echo '<td>'
                                    . $receipt[1]."</td>";
                                            
                                    echo '<td>'
                                    . $receipt[2]."</td>";
                                    echo '<td>'
                                    . $receipt[3]."</td>";
                                    echo '<td>'
                                    . $receipt[4]."</td>";
                                    echo '<td>'
                                    . $receipt[5]."</td>";
                                    if(trim($receipt[6])=='' || trim($receipt[7]=='')){
                                        echo '<td>'
                                    . "Cash"."</td></tr>";
                                    }
                                    else {
                                      
                                        echo '<td>'
                                    . "Cheque"."</td></tr>";
                                     
                                    }
                                   
                                }
                                ?>
                </tbody>
                
            </table>   
            
            
        </div>
   
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    </body>
</html>