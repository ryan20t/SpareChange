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
            <p class="navItemLeft">Spare Change</p>
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
                
                <input type="text" name="amount" id="amount" placeholder="$" />
                
                <div class="category">
                <select>
                    <option disabled selected>Category</option>
                    <option>gas</option>
                    <option>car loan</option>
                    <option>school loans</option>
                </select>
                </div>
                
                <div class="note">
                <input type="text" name="note" id="note" placeholder="note" />
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
    
    <div class="goalTrackerDiv">
        <p class="goalHeader">(goal name)</p>  
        <canvas class="goalCanvas"></canvas>
        <p class="goalFooter">75%</p>
    </div>
    
    
    <div class="transactionView">
        <div class="transViewHeader">
            <select class="rangeSelector"><option>Current</option></select>
            <ul class="dayMonth">
                <li><p id="daySelector">Day</p></li>
                <li>|</li>
                <li><p id="monthSelector">Month</p></li>
            </ul>
        </div>
        <br />
        
        
        <!--
            output by day
        -->
        <br />
        <div class="dayView">
        <table class="dayTable">
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
            
            <div class="daySummary">
                <p>Monday, July 7th 2014</p><br /><br />
                <p>Total funds:</p><br /><br />
                <p>Spent:</p><br /><br />
                <p>Remaining:</p>
            </div>
            
            
        </div>
        
        
        <!--
            output by month
        -->
        <div class="monthView">
            <table class="monthTable">
                <th>
                <tr>
                    <td class="underline">Date</td>
                    <td class="underline">Spent</td>
                    <td class="underline">Left</td>
                </tr>
                </th>
                <tr>
                    <td>Tuesday, 7/1</td>
                    <td>$30</td>
                    <td>$5</td>
                </tr>
                <tr>
                    <td>Wednesday, 7/2</td>
                    <td>$25</td>
                    <td>$10</td>
                </tr>
                <tr>
                    <td>Thursday, 7/3</td>
                    <td>$18</td>
                    <td>$17</td>
                </tr>
                <tr>
                    <td>Friday, 7/4</td>
                    <td>$5</td>
                    <td>$30</td>
                </tr>
                <tr>
                    <td>Saturday, 7/5</td>
                    <td>$38</td>
                    <td>-$3</td>
                </tr>
            </table>
            
            <div class="monthSummary">
                <p>July, 2014</p><br /><br />
                <p>Total funds:</p><br /><br />
                <p>Spent:</p><br /><br />
                <p>Remaining:</p>
            </div>           
        </div>
    </div><!-- closing tag for .transactionView div -->
    
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
        
    </body>
</html>
