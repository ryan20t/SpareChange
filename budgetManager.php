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
        <title>budget manager</title>
        <link href="css/reset.css" type="text/css" rel="stylesheet">
        <link href="css/settings.css" type="text/css" rel="stylesheet">
    </head>
    <body class='budgetManBody'>
        <?php
        // put your code here
        ?>
        
        <div class='budgetManagerDiv'>
        <table class="budgetManagerTable">
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
        </div>
        
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/global.js"></script>
        <script type="text/javascript" src="js/sorttable.js.js"></script>
        
        
    </body>
</html>
