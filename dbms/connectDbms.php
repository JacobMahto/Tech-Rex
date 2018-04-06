<?php
$username = 'root';//user name for mysql
$password = 'lion';//password for mysql
$host = 'localhost';//server
$dbName = 'rsl';//name of the database
$port = '3306';//name of the connection port
$socket = '';

$connection = mysqli_connect($host,$username,$password,$dbName);

if($connection){
    
}
else{
    die('Database connection failed.');
}
