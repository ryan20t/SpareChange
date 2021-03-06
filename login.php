<?php include 'dependency.php'; ?>
<!DOCTYPE html>
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
        
        $signupLogin = new SignupLogin();
        $elog = new ErrorLog(); //instance of ErrorLog to pull errors
        
        /*
         * determine user action:
         * sign up or log in
         */
        if ( isset($_POST['Signup']) )
        {
            //filter input variables from post request
            $email = filter_input(INPUT_POST, 'email');
            $confirmEmail = filter_input(INPUT_POST, 'confirmEmail');
            $password = filter_input(INPUT_POST, 'password');
            $confirmPassword = filter_input(INPUT_POST, 'confirmPw');

            if ( $elog->signupValid() )
            {
                $date = date("Y-m-d"); //to insert as sign up date
                $id = $signupLogin->saveSignup($email, $password, $date);
                if ($id)
                {
                    $_SESSION['id'] = $id;
                    header("Location: index.php");
                }
            }
            else
            {
                $errors = $elog->getErrors();
            }
            
        }
        else if ( isset($_POST['Login']) )
        {   
            
            $email = filter_input(INPUT_POST, 'email');
            $password = filter_input(INPUT_POST, 'password');
            
            if ( $elog->loginValid() ) //valid login
            { 
                if ( $signupLogin->loginIsCorrect($email, $password) )
                {
                    header("Location: index.php");
                }
            }
            else //invalid login
            {
                $errors = $elog->getErrors();
            }
              
        }
        
        ?>
        <!--
            header bar
        -->
        <center class="loginTop"> 
            <p id="signupMessage" class="navItemRight" >already a member? <button onclick="SwitchToLogin()">log in</button></p>
            <p id="loginMessage" class="navItemRight" >not a member? <button onclick="SwitchToSignup()">register</button></p>
        </center>
        
    
        <div class="loginSignupWrap">
            
        <!--
            sign up form
        -->
        <fieldset id="signup" class="fieldset">
            <form name="signupForm" action="#" method="post">
                <input type="text" class="email" name="email" placeholder="e-mail" value="<?php echo $email; ?>" />
                <?php if ( isset($_POST['Signup']) && $errors['email'] ) {echo '<br />',$errors['email'];} ?><br />
                
                <input type="text" class="confirmEmail" name="confirmEmail" placeholder="confirm e-mail" value="<?php echo $confirmEmail; ?>" />
                <?php if ( isset($_POST['Signup']) && $errors['confirmEmail'] && !$errors['email'] ) {echo '<br />',$errors['confirmEmail'];} ?><br />
                
                <input type="password" class="password" name="password" placeholder="password" />
                <?php if ( isset($_POST['Signup']) && $errors['password'] ) {echo '<br />',$errors['password'];} ?><br />
                
                <input type="password" class="confirm" name="confirmPw" placeholder="confirm pw" />
                <?php if ( isset($_POST['Signup']) && $errors['confirmPw'] && !$errors['password'] ) {echo '<br />',$errors['confirmPw'];} ?><br />
                
                <input type="submit" class="submit" name="Signup" value="Signup" />
            </form>
        </fieldset>
        
        <!--
            log in form
        -->
        <fieldset id="login" class="fieldset">
            <form name="loginForm" action="#" method="post">
                <input type="text" class="email" name="email" placeholder="e-mail" value="<?php echo $email; ?>" />
                <?php if ( isset($_POST['Login']) && $errors['email'] ) {echo '<br />',$errors['email'];} ?><br />  
                
                <input type="password" class="password" name="password" placeholder="password" />
                <?php if ( isset($_POST['Login']) && $errors['password'] ) {echo '<br />',$errors['password'];} ?><br />
                
                <input type="submit" class="submit" name="Login" value="Login" />
            </form>
        </fieldset>
            
        </div><!-- loginSignupWrap -->
        
    
        <!-- Script, etc -->        
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/login.js"></script>
        <script type="text/javascript" src="js/global.js"></script>
        
        <!-- Keep sign up form visible -->        
        <?php 
            if ( Util::isPostRequest() && isset($_POST['Signup']) )
            {
                echo '<script type="text/javascript">'.'SwitchToSignup()'.'</script>';
            }
        ?>
        
    </body>
</html>