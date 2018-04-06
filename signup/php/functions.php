<?php
$username = 'root';//user name for mysql
$password = 'lion';//password for mysql
$host = 'localhost';//server
$dbName = 'rsl';//name of the database
$port = '3306';//name of the connection port
$socket = '';

$connection = mysqli_connect($host,$username,$password,$dbName);

function registration(){
    global $connection;
    if (isset($_POST['submit'])) {
  if($_POST['password'] === $_POST['passwordConfirm']){
      $name = $_POST['name'];
      $father = $_POST['father'];
      $spouse = $_POST['spouse'];
      $dob = $_POST['dob'];
      $address = $_POST['address'];
      $dpt = $_POST['dpt'];
      $contact = $_POST['contact'];
      $mail = $_POST['mail'];
      $password = $_POST['password'];
      $sex = $_POST['sex'];
      
      mysqli_real_escape_string($connection,$name);
      mysqli_real_escape_string($connection,$father);
      mysqli_real_escape_string($connection,$spouse);
      mysqli_real_escape_string($connection,$dob);
      mysqli_real_escape_string($connection,$address);
      mysqli_real_escape_string($connection,$dpt);
      mysqli_real_escape_string($connection,$contact);
      mysqli_real_escape_string($connection,$mail);
      mysqli_real_escape_string($connection,$password);
      mysqli_real_escape_string($connection,$sex);
      
      $insert_query = "INSERT INTO user_info(name,father_name";
      $insert_query .= ",spouse_name,dob,address,dpt,contact,mail,password,sex)";
      $insert_query .=" VALUES(";
      $insert_query .= "'$name','$father','$spouse','$dob','$address','$dpt',$contact,'$mail','$password','$sex');";
      
      $resultSet = mysqli_query($connection, $insert_query);
      
      if(!$resultSet){
          echo "<html><body><script>alert('Fatal Server Error. Contact J.Mahto.');window.location = 'index.php';</script></body></html>";
      }
      else{
          echo "<html><body><script>alert('Registered. Your ID will be given to you by J.Mahto.');window.location = 'index.php';</script></body></html>";
      }
  }
      else {
     
echo "<html><body><script>alert('Passwords don\'t Match. Try again.');window.location = 'index.php';</script></body></html>";


}
  
      
  }
}

?>