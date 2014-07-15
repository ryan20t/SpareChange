<!DOCTYPE html>
<?php include 'dependency.php'; ?>
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
        // put your code here
        ?>
        
        <center class="top">
            <p class="navItemLeft">Spare Change</p>
            <ul class="navList">
                <li>Hello, (username)</li>
                <li>|</li>
                <li><a href="index.php">Dashboard</a></li>
                <li>|</li>
                <li class="underline">Settings</li>
                <li>|</li>
                <li><p>Sign out</p></li>
            </ul>
        </center>
        
    
    <div class="income">
        <form name="income" action="#" method="post">
            Weekly income: &nbsp;$500.00&nbsp;&nbsp;
            <input type="text" name="income" />
            <input type="submit" name="Update" value="Update" />
        <form>
    </div>
    
    <div class="staticBills">
        <p>Static Bills</p>
        <table class="staticTable">
            <tr>
                <td>phone</td>
                <td>$70.00</td>
            </tr>
            <tr>
                <td>car</td>
                <td>$300.00</td>
            </tr>
            <tr>
                <td>school loans</td>
                <td>$275.00</td>
            </tr>
        </table>
        
        <br /><br />
        
        <p class="underline">Modify Static Bills</p>
        
        <br /><br />
    </div>
    
    <div class="budgetItems">
        <p>Budget Items</p>
        <table class="budgetTable">
            <tr>
                <td>gas</td>
                <td>$200.00</td>
            </tr>
            <tr>
                <td>hair</td>
                <td>$20.00</td>
            </tr>
            <tr>
                <td>cats</td>
                <td>$75.00</td>
            </tr>
        </table>
        
        <br /><br />
        
        <p class="underline">Modify Budget Items</p>
        
        <br /><br />
    </div>
    
    <div class="accountManagement">
        <p>Manage Account</p>
        <ul class="accountList">
            <li>Change Password</li>
            <li>Delete Account</li>
        </ul>
        
        <br /><br />
    </div>
        
    <script type="text/javascript" src="js/jquery.js"></script>
        
    </body>
</html>
