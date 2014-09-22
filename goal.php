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
        <title>goal management</title>
        <link href="css/reset.css" type="text/css" rel="stylesheet">
        <link href="css/global.css" type="text/css" rel="stylesheet">
        <link href="css/settings.css" type="text/css" rel="stylesheet">
        <link href="css/goal.css" type="text/css" rel="stylesheet">
        
        <link rel="stylesheet" href="jqui/jquery-ui.min.css">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="jqui/jquery-ui.min.js"></script>
    </head>
    <body>
        <?php
        
            $crud = new CRUD();
            $goal = $crud->getGoal();
            
            //check for goal insertion/update
            if ( Util::isPostRequest() && isset($_POST['submit']) )
            {
                $name = filter_input(INPUT_POST, 'goalName');
                $amount = filter_input(INPUT_POST, 'amount');
                
                $goalSuccess = $crud->addGoal($name, $amount);
                
                if ( $goalSuccess )
                {
                    header("Location: goal.php");
                }
                else
                {
                    
                }
            }
            
            //check for delete request
            if ( Util::isPostRequest() && isset($_POST['deleteGoal']) )
            {
                $crud->removeGoal();
                header("Location: goal.php");
            }
            
            //check for contribution
            if ( Util::isPostRequest() && isset($_POST['contribute']) )
            {
                $t = new TransactionModel("category", filter_input_array(INPUT_POST));
                $t->setCategory("savings");
                
                if ( $t->getAmount() > 0 )
                {
                    $success = $crud->insertTransaction($t);
                }
                else
                {
                    
                }
                
                if ( $success )
                {
                    header("Location: goal.php");
                }
                else
                {
                    
                }
            }
        ?>
        
        <div class="goalDiv">
            
            <!-- output goal info -->
            <?php
                if ( $goal )
                {
                    echo '<p class="goalHeader">',$goal['goal_name'],' $',$goal['amount'],'</p>';
                }
                else
                {
                    echo '<p class="goalHeader">you have not set up a savings goal</p>';
                }
            ?>
            
            <br /><br />
            <form name="goalForm" action="#" method="post">
                
                <p>modify/remove goal</p><br/>
                
                <input class="goalName" type="text" name="goalName" placeholder="goal name" maxlength="25"/>
                
                <span class="dollarSign">$</span>
                <input class="amount" type="text" name="amount" id="amount" placeholder="amount" maxlength="14"/>
                
                <input type="submit" class="submit" name="submit" value="submit"/><br />
                
                    <?php 
                    if ( Util::isPostRequest() && isset($_POST['submit']) )
                    {
                        if ( !IsValid::notEmpty($_POST['goalName']) || !IsValid::notEmpty($_POST['amount']) )
                        {
                            echo '<br />name and amount are required<br />';
                        }                        
                    }
                    ?>
                <input type="hidden" name="category" value="savings" />
                <input type="hidden" name="note" value="" />
                
                <input type="submit" class="deleteGoal" name="deleteGoal" value="remove goal" onclick="return confirm('delete goal?');" /><br /><br /><br />
                
            </form>
            
            <br /><br /><br />
            
            <form name="contribution" action="#" method="post">
                
                <p>contribute to goal</p><br />
                
                <input type="text" name="date" id="date" class="date" value="<?php echo date("m/d/Y");; ?>" placeholder="date" readonly/>
                
                <span class="dollarSign">$</span>
                <input class="amount" type="text" name="amount" id="amount" placeholder="amount" maxlength="14"/>
                
                <input type="submit" name="contribute" value="Contribute" />

            </form>
            
            <?php 
            if ( Util::isPostRequest() )
            {
                if ( $t->getAmount() == 0 )
                {
                    echo 'amount required';
                }
            }
            ?>
            
        </div>
        
    <br/><br/>
    <button id="backButton" class="submit" onclick="location.href='settings.php'">back</button>
        
    <script type="text/javascript" src="js/global.js"></script>
    <script type="text/javascript" src="js/goal.js"></script>
        
    </body>
</html>
