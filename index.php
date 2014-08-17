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
                }
                else 
                {
                    echo "fail";
                }
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
                    <input class="noteInput" type="text" name="note" id="note" placeholder="note" maxlength="50"/>
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
    
    <div class="transactionView">
        <div class="transViewHeader">
            <!--(current date, ex: Monday, July 7 2014)-->
            <?php echo date("l\, F jS");; ?>
        </div>
        <br />
        
        <div class="goalTrackerDiv">
            <p class="goalHeader">(goal name)</p>  
            <canvas class="goalCanvas"></canvas>
            <p class="goalFooter">75%</p>
        </div>
    
        <!--
            output by day
        
        <br />-->
        <div class="dayView">
        <table class="dayTable">
            <tr>
                <th class="underline">amount</th>
                <th class="underline">note</th>
            </tr>
            <?php 
                $today = $crud->getToday();
                //print_r($today);
                foreach( $today as $today )
                {
                    echo '<tr><td>'.$today['amount'].'</td><td>'.$today['note'].'</td></tr>';
                }
            ?>
        </table>
        </div>
        
        <!-- Summary -->
        <div class="daySummary">
            <p>Daily funds:</p><br />
            <p>Spent:</p><br />
            <p>Remaining:</p>
        </div>
        
    </div><!-- closing tag for .transactionView div -->
    
    <!-- JavaScript -->
    <script type="text/javascript" src="js/index.js"></script>
    <script type="text/javascript" src="js/global.js"></script>
    <script type="text/javascript" src="js/sorttable.js"></script>

    </body>
</html>
