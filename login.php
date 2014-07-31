<!DOCTYPE html>
<?php include 'dependency.php'; ?>
<!--

-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Spare Change</title>
        <link href="css/global.css" type="text/css" rel="stylesheet">
        <link href="css/login.css" type="text/css" rel="stylesheet">
        <link href="css/reset.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <?php
        
        ?>
        <!--
            header bar
        -->
        <center class="loginTop"> 
            <!-- <p class="navItemLeft">Spare Change</p> --> 
            <p id="signupMessage" class="navItemRight" >already a member? <button onclick="SwitchToLogin()">log in</button></p>
            <p id="loginMessage" class="navItemRight" >not a member? <button onclick="SwitchToSignup()">register</button></p>
        </center>
        
        <div class="loginSignupWrap">
        <!--
            sign up form
        -->
        <fieldset id="signup" class="fieldset">
            <form name="signupForm" action="#" method="post">
                <input type="text" class="email" name="email" placeholder="e-mail" /><br />
                <input type="password" class="password" name="password" placeholder="password" /><br />
                <input type="password" class="confirm" name="confirm" placeholder="confirm pw" /><br />
                <input type="submit" class="submit" name="Register" value="register" />
            </form>
        </fieldset>
        
        
        
        <!--
            log in form
        -->
        <fieldset id="login" class="fieldset">
            <form name="loginForm" action="#" method="post">
                <input type="text" class="email" name="email" placeholder="e-mail" /><br />
                <input type="password" class="password" name="password" placeholder="password" /><br />
                <input type="submit" class="submit" name="Login" value="log In" />
            </form>
        </fieldset>
            
        </div>
        
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/login.js"></script>
        <script type="text/javascript" src="js/global.js"></script>
        
    </body>
</html>