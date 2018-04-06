<?php

include './php/functions.php';
registration();


?>

<!DOCTYPE html>
<html>
    <head>
        <title>JRL| Registration</title>
        <!-- Meta tag Keywords -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Flat Sign Up Form Responsive Widget Template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
              Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
            function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!-- Meta tag Keywords -->
        <!-- css files -->
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all">
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">
        <!-- //css files -->
        <!-- online-fonts -->
        <link href='//fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'><link href='//fonts.googleapis.com/css?family=Raleway+Dots' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <!--header-->
        <div class="header-w3l">
            <h1>M.K. PUBLIC SR. SEC. SCHOOL</h1>
        </div>
        <!--//header-->
        <!--main-->
        <div class="main-agileits">
            <h2 class="sub-head">Staff Registration</h2>
            <div class="sub-main">	
                <form action="index.php" method="post">
                    <input placeholder="Your Name" name="name" class="name" type="text" required="">    
                    <span class="icon1"><i class="fa fa-user"></i></span>
                    <select class="select" value='sex' name="sex"  required=""  style="color:gray;">
                        <option value="male" >Male</option>
                        <option value="female">Female</option>    
                        <option value="transgender">Not to say</option>                          
                    </select>
                    <span class="icon"><i class="fa fa-genderless"></i></span>
                    <input placeholder="Father's Name" name="father" class="father" type="text" required="">  
                    <span class="icon"><i class="fa fa-user"></i></span>
                    <input placeholder="Spouse Name" name="spouse" class="spouse" type="text" required="">     
                    <span class="icon"><i class="fa fa-user"></i></span>
                    <input placeholder="Birth Date (03/05/2018)" name="dob" class="date" type="date" required="">    
                    <span class="icon"><i class="fa fa-calendar"></i></span>
                    <input placeholder="Address" name="address" class="address" type="text" required="">
                    <span class="icon"><i class="fa fa-home"></i></span>                    
                    <select class="select" value='department' name="dpt"  required=""  style="color:gray;">
                        <option value="teaching" >Teaching</option>
                        <option value="admin">Admin</option>    
                        <option value="clerk">Clerk/Office</option> 
                        <option value="admin">Housekeeping</option> 
                    </select>                    
                    <span class="icon"><i class="fa fa-anchor"></i></span>
                    <input placeholder="Phone No." name="contact" class="name" type="text" required=""> 
                    <span class="icon"><i class="fa fa-phone"></i></span>
                    <input placeholder="Email" name="mail" class="mail" type="text" required="">  
                    <span class="icon"><i class="fa fa-envelope"></i></span>
                    <input  placeholder="Password" name="password" class="pass" type="password" required="">   
                    <span class="icon"><i class="fa fa-lock"></i></span>
                    <input  placeholder="Confirm Password" name="passwordConfirm" class="pass" type="password" required="">
                    <span class="icon"><i class="fa fa-lock"></i></span>
                    <input type="submit" value="sign up" name="submit">

                </form>
            </div>
            <div class="clear"></div>
        </div>
        <!--//main-->

        <!--footer-->
        <div class="footer-w3">
            <p>&copy; 2018 Jacob Research Lab. All rights reserved | Powered by <a href="#">Jacob V. Mahto</a></p>
        </div>
        <!--//footer-->

    </body>
</html>