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
    <title>Transaction History</title>
    <link href="css/global.css" type="text/css" rel="stylesheet">
    <link href="css/reset.css" type="text/css" rel="stylesheet">
    <link href="css/transHistory.css" type="text/css" rel="stylesheet">
</head>
    
<body>
    <?php
    // put your code here
    ?>
    
    <center class="top">
        <img class="logoLeft" src="img/smpink.png" alt="" />
        <ul class="navList">
            <li><a href="index.php">dashboard</a></li>
            <li>|</li>
            <li class="underline">transactions</li>
            <li>|</li>
            <li><a href="settings.php">settings</a></li>
            <li>|</li>
            <li><p><a href="?logout=1">sign out</a></p></li>
        </ul>
    </center>

    <div class="contentWrap">
    <header class="historyHeader">
    <select>
        <option>year</option>
    </select>
    <select>
        <option>month</option>
    </select>
    </header>

    <div class="historyTableDiv">
        <table class="sortable historyTable">
            <tr>
                <th><p>day</p></th>
                <th><p>month</p></th>
                <th><p>day</p></th>
                <th><p>year</p></th>
                <th><p>amount</p></th>
                <th><p>note</p></th>
            </tr>
            <tr>
                <td>Monday</td>
                <td>July</td>
                <td>21</td>
                <td>2014</td>
                <td>$20.00</td>
                <td>beer</td>
            </tr>
            <tr>
                <td>Tuesday</td>
                <td>April</td>
                <td>29</td>
                <td>2012</td>
                <td>$10.40</td>
                <td>food</td>
            </tr>
            <tr>
                <td>Tuesday</td>
                <td>April</td>
                <td>09</td>
                <td>2010</td>
                <td>$5.29</td>
                <td>food</td>
            </tr>
            <tr>
                <td>Wednesday</td>
                <td>May</td>
                <td>02</td>
                <td>2011</td>
                <td>$80.00</td>
                <td>wal mart</td>
            </tr>
        </table>
    </div>
    </div>


<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript" src="js/sorttable.js"></script>
</body>
</html>
