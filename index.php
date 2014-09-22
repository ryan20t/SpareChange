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
        
        <!-- CSS -->
        <link href="css/global.css" type="text/css" rel="stylesheet">
        <link href="css/index.css" type="text/css" rel="stylesheet">
        <link href="css/reset.css" type="text/css" rel="stylesheet">
        
        <!-- jQuery UI -->
        <link rel="stylesheet" href="jqui/jquery-ui.min.css">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="jqui/jquery-ui.min.js"></script>
                
        <title>Spare Change Dashboard</title>
    </head>
    <body>
        <?php
        $crud = new CRUD(); //used to interact with DB throughout the page

        //INSERT NEW TRANSACTION
        if ( Util::isPostRequest() && isset($_POST['submit']) )
        { 
            //type variable used to null category or note field on TransactionModel map
            if ( isset($_POST['budgetBox']) && $_POST['budgetBox'] === "category" )
            {
                $type = "category";
            }
            else
            {
                $type = "note";
            }
            
            $transaction = new TransactionModel($type, filter_input_array(INPUT_POST));
            $validData = false;
            
            //test for valid data
            if (   IsValid::notEmpty($transaction->getDate() )
                && IsValid::notEmpty($transaction->getAmount() )
                && IsValid::isDecimal( $transaction->getAmount() ) 
                && IsValid::isDate($transaction->getDate() ) )
            {
                if ( $type === "note" && IsValid::notEmpty($transaction->getNote() ) )
                {
                    $validData = true;
                }
                else if ( $type === "category" && isValid::notEmpty($transaction->getCategory() ) )
                {
                    $validData = true;
                }
            }
            
            //perform insert
            if ( $validData )
            {
                $success = $crud->insertTransaction($transaction);
                
                if ( $success )
                {
                    echo "success";
                    header("Location: index.php");
                }
                else 
                {
                    echo "fail";
                }
            }
        }
        
        //CHECK FOR TRANSACTION TO DELETE
        if ( isset($_POST['tid']) && Util::isPostRequest() )
        {
            $tid = filter_input(INPUT_POST, 'tid');
            $successfulDelete = $crud->deleteTransaction($tid);
            
            if ( $successfulDelete )
            {
                unset($_POST['tid']);
                header("Location: index.php");
            }
        }
        
        ?>
        
        <!--
            header bar
        -->
        <center class="top">
            <img class="logoLeft" src="img/smpink.png" alt="" />
            <ul class="navList">
                <li class="underline">dashboard</li>
                <li>|</li>
                <li><a href="transHistory.php">transactions</a></li>
                <li>|</li>
                <li><a href="settings.php">settings</a></li>
                <li>|</li>
                <li><p><a href="?logout=1">sign out</a></p></li>
            </ul>
        </center>
    
    <!--
        this section is used to input daily
        transactions
    -->
    <div class="transactionEntry">
        <fieldset>
            <form name="newEntry" method="post" action="#">
                <input type="text" name="date" id="date" class="date" value="<?php echo date("m/d/Y");; ?>" placeholder="date" readonly/>
                
                <span class="dollarSign">$</span>
                <input class="amount" type="text" name="amount" id="amount" placeholder="amount" maxlength="14"/>
                
                
                <!-- Output Budget Category List -->
                <?php
                
                $categoryList = $crud->getCategories();
                
                if ( $categoryList[0] )
                {
                    echo '<div class="category"><select name="category">';
                    foreach( $categoryList as $value )
                    {
                        echo '<option>'.$value.'</option>';
                    }
                    echo '</select></div>';
                }
                else
                {
                    echo '<div class="category"><select name="category" style="color: Gray"><option disabled selected>'."no budget categories".'</option></select></div>';
                }
                ?>
                
                <div class="note">
                    <input class="noteInput" type="text" name="note" id="note" placeholder="note" maxlength="25"/>
                </div>
                
                &nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="budgetBox" value="category" id="budgetBox" />budget item
                
                &nbsp;&nbsp;&nbsp;
                <input type="submit" name="submit" value="Submit" />
            </form>
        </fieldset>  
    </div>
      
    
    <!--
        this is the main output section of the application
        it shows spending and leftover money by day, week
        or month
    -->
    
    <?php 
        
        //calculate daily limit/spending etc
        $bills = $crud->getBills();    //bills array (bill_name, amount, frequency) from DB
        $billsDailyTotal = 0;          //total of bills after conversion to daily amount

        //change bill amounts to daily occurrence values
        if ( $bills )
        {
            foreach ( $bills as $key => $values)
            {
                $bills[$key]['amount'] = Util::toDesiredFrequency($values['amount'], $values['frequency'], 365);
                $billsDailyTotal += $bills[$key]['amount'];
            }
        }

        //get income info
        $income = $crud->getIncome();   //income array (amount, frequency)
        $dailyIncome = Util::toDesiredFrequency($income['amount'], $income['frequency'], 365);

        //get transactions
        $today = $crud->getToday();  //array of today's transactions
        $dailyTransactionTotal = 0;  //will store transaction total
    
    ?>    
    
    <div class="transactionView">
        <div class="transViewHeader">
            <!--(current date, ex: Monday, July 7 2014)-->
            <?php echo strtolower(date("l\, F jS")); ?>
        </div>
        <br />
        
        <!-- goal tracker -->
        <?php
        
        $goal = $crud->getGoal();
        $runningTotal = $crud->getGoalTotal();
        $percent = Util::getPercent($goal['amount'], $runningTotal);

        if ( null !== $goal )
        {
            echo '<div class="goalTrackerDiv"><p class="goalHeader">',$goal['goal_name'],': $',$goal['amount']; //goal div and header
            echo '</p>','<canvas class="goalCanvas"></canvas>'; //goal canvas
            echo '<p class="goalFooter">$',$runningTotal,'<br />',$percent,'%','</p>'; //goal footer
            echo '<button class="goalButton" id="goalButton" onclick="location.href=\'goal.php\'">contribute</button>';
            echo '</div>'; //end of goal div
        }
        else
        {
            echo '<div class="goalTrackerDiv"><p class="goalHeader">no goal</p>';
            echo '<p class="goalFooter"><button class="goalButton" id="goalButton" onclick="location.href=\'goal.php\'">add goal</button></p></div>';
        }
        
        ?>
        
        <!--
            output by day
        
        -->
        <div class="dayView">
        <table class="dayTable">
            
            <?php if (!$today) { echo '<p class="noMoneySpent">you have not spent any money today</p>'; } ?>
            
            <?php
            if ($today)
            {
            echo '<tr><th class="underline">amount</th><th class="underline">note</th></tr>';
            }
            ?>
            
            <!-- Output Today's Transactions -->
            <?php 
            
                //output and total daily transactions
                if ( $today ) //today is an array of today's transactions
                {
                    foreach( $today as $today )
                    {
                        echo '<tr><td>'.$today['amount'],'</td><td>'.$today['note'],'</td><td><form name="deleteForm" action="#" method="post"><input name="tid" type="hidden" value="',$today['trans_id'],'" /><button type="submit" onclick="return confirm(\'delete transaction?\');">X</button></form></td></tr>';
                        $dailyTransactionTotal += $today['amount'];
                    }
                }
                
                
                //calculate daily spending limit and remaining funds after daily transactions
                $dailySpendingLimit = $dailyIncome - $billsDailyTotal;
                $remaining = round($dailySpendingLimit - $dailyTransactionTotal, 2);
                
            ?>
        </table>
        </div>
        
        <!-- Summary -->
        <div class="daySummary">
            <div class="summarySquare">
                <p class="dSign">$</p>
                <div class="summaryInfo"><?php echo $dailySpendingLimit ?></div>
                <p>daily funds</p>
            </div>
            <br />
            <div class="summarySquare">
                <p class="dSign">$</p>
                <div class="summaryInfo"><?php echo $dailyTransactionTotal ?></div>
                <p>spent</p>
            </div>
            <br />
            <div class="summarySquare">
                <p class="dSign">$</p>
                <div class="summaryInfo"><?php echo $remaining ?></div>
                <p>remaining</p>
            </div>
            <br />
        </div>
        
    </div><!-- closing tag for .transactionView div -->
    
    <!-- JavaScript -->
    <script type="text/javascript" src="js/index.js"></script>
    <script type="text/javascript" src="js/global.js"></script>
    
    <?php
        $fillPercent = ( 100 - $percent ) / 100;
        $fillNumber = $fillPercent * 150;
        
        if ($fillNumber < 0)
        {
            $fillNumber = 0;
        }
        
        echo '<script type="text/javascript">ctx.fillRect(0,',$fillNumber,',300,150);</script>';
    ?>
    
    <!-- check which type was set -->
    <?php
    
        if ( isset($_POST['budgetBox']) && $_POST['budgetBox'] === "category" )
        {
            echo '<script>IsCategory();</script>';
        }
        else
        {
            echo '<script>IsNote();</script>';
        }
    
    ?>
    
    </body>
</html>
