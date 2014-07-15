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
        <center class="top">
            <p class="navItemLeft">Spare Change</p>
            <p id="signupMessage" class="navItemRight" >Already a member? <button onclick="SwitchToLogin()">Log in</button></p>
            <p id="loginMessage" class="navItemRight" >Not a member? <button onclick="SwitchToSignup()">Sign up!</button></p>
        </center>
    
    
    
        <!--
            sign up form
        -->
        <fieldset id="signup" class="fieldset">
            <!-- <legend>Signup</legend> -->
            
            <form name="signupForm" action="#" method="post">
                <input type="text" class="email" name="email" placeholder="e-mail" /><br />
                <input type="password" class="password" name="password" placeholder="password" /><br />
                <input type="password" class="confirm" name="confirm" placeholder="confirm pw" /><br />
                <input type="submit" name="Signup" value="Signup" />
            </form>
        </fieldset>
        
        
        
        <!--
            log in form
        -->
        <fieldset id="login" class="fieldset">
            <!-- <legend>Log In</legend> -->
            
            <form name="loginForm" action="#" method="post">
                <input type="text" class="email" name="email" placeholder="e-mail" /><br />
                <input type="password" class="password" name="password" placeholder="password" /><br />
                <input type="submit" name="Login" value="Log In" />
            </form>
        </fieldset>
            
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/login.js"></script>
        
    </body>
</html>