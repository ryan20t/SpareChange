<?php 
    include 'dependency.php';
    Util::checkLogout();
    Util::confirmAccess();
?>
<!DOCTYPE html>
<!--

-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>account management</title>
        <link href="css/reset.css" type="text/css" rel="stylesheet">
        <link href="css/global.css" type="text/css" rel="stylesheet">
        <link href="css/settings.css" type="text/css" rel="stylesheet">
        <link href="css/accountManagement.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <?php
        
        $signup = new SignupLogin();
        $elog = new ErrorLog();
        $invalidPW = false;
        $pwChanged = false;
        
        //change password
        if ( Util::isPostRequest() && isset($_POST['submitPW']) )
        {
            $oldPW = filter_input(INPUT_POST, 'oldPW');
            $newPW = filter_input(INPUT_POST, 'password');
            $confirmNew = filter_input(INPUT_POST, 'confirmPw');
            
            if ( $elog->pwChangeValid() ) //new information provided is valid
            {
                if ( $signup->passwordChangeCorrect($oldPW) ) //does old PW match
                {
                    if ( $signup->changePW($newPW) ) //perform update
                    {
                        echo "success";
                        $pwChanged = true;
                    }
                    else
                    {
                        echo "failed";
                        $pwChanged = false;
                    }
                }
            }
            if ( !$signup->passwordChangeCorrect($oldPW) && !$pwChanged )
            {
                $invalidPW = true;
            }
        }
        
        //delete account
        if ( Util::isPostRequest() && isset($_POST['delete']) )
        {
            $oldPW = filter_input(INPUT_POST, 'password');
            
            if ( $elog->pwChangeValid() )
            {
                if ( $signup->passwordChangeCorrect($oldPW) )
                {
                    if ( $signup->deleteAccount() )
                    {
                        header("Location: accountManagement.php");
                    }
                    else
                    {
                        //errors
                    }
                }
            }
        }
        
        $errors = $elog->getErrors();
        
        ?>
        
        <p class="underline amTitle">account management</p>
        
        <div class="pwChange">
            
            <p>change password</p>
            
            <form name="pwChange" method="post" action="#">
                <input type="password" name="oldPW" class="password" placeholder="old password"/>
                <?php if ( $invalidPW ) { echo 'invalid password'; } ?><br />
                
                <input type="password" name="password" class="password" placeholder="new password"/>
                <?php if ( $errors['password'] && isset($_POST['submitPW']) ) {echo $errors['password'];} ?><br/>
                       
                <input type="password" name="confirmPw" class="password" placeholder="confirm"/>
                <?php if ( isset($_POST['submitPW']) && !$errors['password'] ) {echo $errors['confirmPw'];} ?><br/>
                
                <input type="submit" name="submitPW" class="submit" value="change"/>
            </form>
        </div>
        
        <div class="deleteAccount">
            
            <p>delete account</p>
            
            <br/>
            
            <p>warning: this will erase your account and all logged transactions</p>
            
            <form name="deleteAccount" method="post" action="#">
                <input type="password" name="password" class="password" placeholder="password"/><?php if ($errors['password'] && isset($_POST['delete'])) {echo $errors['password'];} ?><br/>
                       
                <input type="password" name="confirmPw" class="password" placeholder="confirm"/><?php if ($errors['password'] && isset($_POST['delete'])) {} else if (isset($_POST['delete'])) {echo $errors['confirmPw'];} ?><br/>
                
                <input type="submit" name="delete" class="submit" value="delete" onclick="return confirm('delete account?\nthis will erase all transactions');"/>
            </form>
            
        </div>
        
        <br/><br/>
        <button id="backButton" class="submit" onclick="location.href='settings.php'">back</button>
        
    </body>
    
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/global.js"></script>
    
</html>
