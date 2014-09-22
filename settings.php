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
        <title>Settings</title>
        <link href="css/global.css" type="text/css" rel="stylesheet">
        <link href="css/reset.css" type="text/css" rel="stylesheet">
        <link href="css/settings.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        
    <?php
    
        $crud = new CRUD();
    
        //check to insert bill if necessary
        if ( Util::isPostRequest() && isset($_POST['add']) )
        {
            $elog = new ErrorLog();
            $bill = filter_input_array(INPUT_POST);
            $bill["amount"] = round($bill['amount']);
            
            if ( $elog->billValid() && $bill['billName'] !== "savings" )
            {   
                $successfulBillInsert = $crud->insertBill($bill);
            }
            
            if ( $successfulBillInsert )
            {
                //echo "yes";
                header("Location: settings.php");
            }
            else
            {
                $errors = $elog->getErrors();
                //print_r($errors);
            }
            
        }
        
        //check for bill to delete
        if ( isset($_POST['bid']) && Util::isPostRequest() )
        {
            $bid = filter_input(INPUT_POST, 'bid');
            $successfulDelete = $crud->deleteBill($bid);
            
            if ( $successfulDelete )
            {
                unset($_POST['bid']);
                header("Location: settings.php");
            }
        }

        //GET INCOME INFORMATION
        $incomeInfo = $crud->getIncome();
    
    ?>

    <!-- nav bar -->
    <center class="top">
        <img class="logoLeft" src="img/smpink.png" alt="" />
        <ul class="navList">
            <li><a href="index.php">dashboard</a></li>
            <li>|</li>
            <li><a href="transHistory.php">transactions</a></li>
            <li>|</li>
            <li class="underline">settings</li>
            <li>|</li>
            <li><p><a href="?logout=1">sign out</a></p></li>
        </ul>
    </center>
    
    <!--  -->
    <div class="contentWrap">
        
        <!-- Top section, income and savings goals, plus account management -->
        <div class="settingsPanel income">
            <p class="settingsPanelHeader">
                
            <?php 
                if ($incomeInfo)
                {
                    echo 'income: $',$incomeInfo['amount'],' ',Util::displayFrequency($incomeInfo['frequency']);

                }
                else 
                {
                    echo 'income information not entered';

                }
            ?>
            </p>
            <br /><br />
            <?php
            
            if ($incomeInfo)
            {
            echo '<table>';
                if ($incomeInfo['frequency'] !== 365)
                {
                echo '<tr>
                        <td>daily</td>
                        <td>','$',Util::toDesiredFrequency($incomeInfo['amount'], $incomeInfo['frequency'], 365),'</td>
                    </tr>';
                }
                
                if ($incomeInfo['frequency'] !== 52)
                {
                echo '<tr>
                        <td>weekly</td>
                        <td>','$',Util::toDesiredFrequency($incomeInfo['amount'], $incomeInfo['frequency'], 52),'</td>
                    </tr>';
                }
                
                if ($incomeInfo['frequency'] !== 12)
                {
                echo '<tr>
                        <td>monthly</td>
                        <td>','$',Util::toDesiredFrequency($incomeInfo['amount'], $incomeInfo['frequency'], 12),'</td>
                    </tr>';
                }
                
                if ($incomeInfo['frequency'] !== 1)
                {
                echo '<tr>
                        <td>annually</td>
                        <td>','$',Util::toDesiredFrequency($incomeInfo['amount'], $incomeInfo['frequency'], 1),'</td>
                    </tr>';
                }
            } echo '</table>';
            ?>
        </div>
        
        <div class="buttonWrap">
            <div class="managementButton" onClick="location.href='incomeManager.php'">modify income</div>
            <div class="managementButton" onclick="location.href='goal.php'">add/modify saving goal</div>
            <div class="managementButton" onClick="location.href='accountManagement.php'">account management</div>
        </div>
            
        <div class="settingsPanel savings">
            <?php
            
            $goal = $crud->getGoal();
            
            if ( null !== $goal )
            {
                echo '<p class="settingsPanelHeader">savings goal</p>';
                echo '<p class="settingsPanelInfo">$',$goal['amount'],'</p>';
                echo '<p class="settingsPanelFooter">',$goal['goal_name'],'</p>';
            }
            else
            {
                echo '<p class="settingsPanelHeader">you have not set up a savings goal</p>';
            }
                    
            ?>
        </div>
        
    
    <!-- bills section -->
    <div class="billManagament">
    
        <!-- header -->
        <div class="billsHeader">
            <p class="billsTitle">bills<p>
        </div>
        
        <!-- input -->
        <div class="newBill">
            <fieldset id="newBill">
                <form name="newBill" action="#" method="post">
                    <input type="text" class="billName" name="billName" placeholder="description" value="" maxlength="25" />
                    
                    <span class="dollarSign">$</span>
                    <input type="text" class="amount" name="amount" id="amount" placeholder="amount" maxlength="14" />
                    
                    <span class="radio">
                    <input type="radio" class="billType" name="billType" value="static" checked="checked" />static
                    <input type="radio" class="billType" name="billType" value="budget" />budget
                    </span>
                    
                    <select class="frequency" name="frequency">
                        <option value="365">daily</option>
                        <option value="52">weekly</option>
                        <option value="12" selected>monthly</option>
                        <option value="1">annually</option>
                    </select>
                    
                    <input type="submit" class="submit" name="add" value="add" />
                </form>
            </fieldset>
            
            <?php
                if ($errors)
                {
                    echo 'description and amount are required';
                }
            ?>
            
        </div>
        
        <!-- bills display table -->
        <div class="billsTableDiv">
            <?php
            $crud = new CRUD();
            $bills = $crud->getBills();
            if ( $bills )
            {
                echo '<table class="billsTable"><tr><th>bill</th><th>amount</th><th>frequency</th><th>type</th></tr>';
                foreach ( $bills as $bills )
                {
                    echo '<tr><td>',$bills['bill_name'],'</td><td>',$bills['amount'],'</td><td>',$bills['frequency'],'</td><td>',$bills['bill_type'],'</td><td><form name="deleteForm" action="#" method="post"><input name="bid" type="hidden" value="',$bills['bill_id'],'" /><button type="submit" onclick="return confirm(\'delete bill?\');">X</button></form></td></tr>';
                }
                echo '</table>';
            }
                
            ?>
        </div>
        
    </div><!--for .billManagement --> 
        
    </div><!-- for .contentWrap -->
    
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/global.js"></script>
    <script type="text/javascript" src="js/sorttable.js"></script>
    <script type="text/javascript" src="js/settings.js"></script>
        
    </body>
</html>
