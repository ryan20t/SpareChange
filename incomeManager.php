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
        <title>income management</title>
        <link href="css/reset.css" type="text/css" rel="stylesheet">
        <link href="css/global.css" type="text/css" rel="stylesheet">
        <link href="css/settings.css" type="text/css" rel="stylesheet">
        <link href="css/incomeManager.css" type="text/css" rel="stylesheet">
    </head>
    <body class='incomeBody'>
        <?php
            $crud = new CRUD();
            $elog = new ErrorLog();
            $income = $crud->getIncome();
            
            //check for income update
            if ( isset($_POST['submitIncome']) && Util::isPostRequest() )
            {
                $incomeAmount = filter_input(INPUT_POST, 'amount');
                $incomeFreq = filter_input(INPUT_POST, 'frequency');

                $incomeSuccess = $crud->updateIncome($incomeAmount, $incomeFreq);

                if ( $incomeSuccess )
                {
                    header("Location: incomeManager.php");
                }
                else 
                {
                    echo '<p class="errorMessage">amount required</p>';
                }
            }
            
        ?>
        
        <div class='incomeDiv'>
            <!-- income output -->
            <?php 
                if ( $income )
                {
                    echo '<p class="incomeHeader">$',$income[amount],' ',Util::displayFrequency($income['frequency']),'</p>';
                }
                else
                {
                    echo '<p class="incomeHeader">income information not entered</p>';
                }    
            ?>
            
            <br /><br />
            <form name="income" action="#" method="post">
                <span class="dollarSign">$</span>
                <input class="amount" type="text" name="amount" id="amount" placeholder="amount" maxlength="14"/>
                
                <select class="frequency" name="frequency">
                    <option value="365">daily</option>
                    <option value="52" selected>weekly</option>
                    <option value="12">monthly</option>
                    <option value="1">annually</option>
                </select>
                
                <input type="submit" name="submitIncome" value="update" class="submit" />
            </form>
            
            
        </div>
        
        <button id="backButton" class="submit" onclick="location.href='settings.php'">back</button>
        
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/global.js"></script>
        <script type="text/javascript" src="js/incomeManager.js"></script>
        
    </body>
</html>
