<?php
if (isset($_POST['submit'])) {
    echo "jacob";
}
?>
<!DOCTYPE html>

<html>

    <head>
        <title>Tech-Res Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="css/cssLogin.css">
    </head>
    <body>
        <header>
            <div class="top">
                TECH-REX SERVER POWERED BY JACOB RESEARCH LAB                   
            </div>

        </header>
        <form action="fee/feeCentral.php" method="post">

            <div class="imgcontainer">
                <img src="images/schoolLogo.jpg" alt="Avatar" class="avatar">
            </div>

            <div class="container">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>

                <button type="submit" name="submit">ACCESS OVERRIDE</button>
                <label>
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>
            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" class="cancelbtn">Register</button>
                <span class="psw">Forgot <a href="#">password?</a></span>
            </div>
        </form>
    </body>
</html>
