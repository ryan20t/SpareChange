<!DOCTYPE html>
<?php include 'dependency.php'; ?>
<!--

-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="css/global.css" type="text/css" rel="stylesheet">
        <link href="css/index.css" type="text/css" rel="stylesheet">
        <link href="css/reset.css" type="text/css" rel="stylesheet">   
        <title>Spare Change Dashboard</title>
    </head>
    <body>
        <?php
        // put your code here
        
        ?>
        
        <!--
            header bar
        -->
        <center class="top">
            <img class="logoLeft" src="img/smpink.png" alt="" />
            <ul class="navList">
                <li>Hello, (username)</li>
                <li>|</li>
                <li class="underline">Dashboard</li>
                <li>|</li>
                <li><a href="settings.php">Settings</a></li>
                <li>|</li>
                <li><p>Sign out</p></li>
            </ul>
        </center>
    
    <!--
        this section is used to input daily
        transactions
    -->
    <div class="transactionEntry">
        <fieldset>
            <form name="newEntry" method="post" action="#">
                <input type="text" name="date" id="date" value="" placeholder="date"/>
                
                <input class="amount" type="text" name="amount" id="amount" placeholder="$" />
                
                <div class="category">
                <select>
                    <option disabled selected>Category</option>
                    <option>gas</option>
                    <option>car loan</option>
                    <option>school loans</option>
                </select>
                </div>
                
                <div class="note">
                <input class="noteInput" type="text" name="note" id="note" placeholder="note" />
                </div>
                
                &nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="budgetBox" value="BbudgetBox" id="budgetBox" />Budget Item
                
                &nbsp;&nbsp;&nbsp;
                <input type="submit" name="Submit" value="Submit" />
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
            (current date, ex: Monday, July 7 2014)
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
                <th class="underline">Amount</th>
                <th class="underline">Note/Category</th>
            </tr>
            <tr>
                <td>$8.00</td>
                <td>Subway</td>
            </tr>
            <tr>
                <td>$2.54</td>
                <td>Dunkin' Donuts</td>
            </tr>
            <tr>
                <td>$10.54</td>
                <td>Movies</td>
            </tr>
            <tr>
                <td>$20.00</td>
                <td>Beer</td>
            </tr>
            <tr>
                <td>$2.54</td>
                <td>Dunkin' Donuts</td>
            </tr>
        </table>

        </div>
        
        <div class="daySummary">
            <p>Monday, July 7 2014</p><br />
            <p>Daily funds:</p><br />
            <p>Spent:</p><br />
            <p>Remaining:</p>
        </div>
        
        <p class="underline transViewFooter">transaction history</p>
        
    </div><!-- closing tag for .transactionView div -->
    
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <script type="text/javascript" src="js/global.js"></script>
    <script type="text/javascript" src="js/sorttable.js"></script>
    </body>
</html>
