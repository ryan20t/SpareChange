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
    $crud = new CRUD();
    
    //check for transactions to delete
    if ( Util::isPostRequest() && isset($_POST['delete']) )
    {
        if ( isset($_POST['id']) )
        {
            $ids = filter_input_array(INPUT_POST);
            
            foreach ( $ids['id'] as $key => $value )
            {
                $crud->deleteTransaction($ids['id'][$value]);
            }
        }
    }
    
    //set initial values
    
    if (isset($_POST['year']))
    {
        $selYear = filter_input(INPUT_POST, 'year');
    }
    else
    {
        $selYear = date("Y");
    }
    if (isset($_POST['month']))
    {
        $selMonth = filter_input(INPUT_POST, 'month');
        //$passMonth = filter_input(INPUT_POST, 'month');
    }
    else
    {
        $selMonth = "00";
        //$passmonth = "01";
    }
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
    <form name="headerForm" action="#" method="post">
    year
    <select name="year" onchange="headerForm.submit();">
        <?php
        $years = $crud->getYears();
        foreach ($years as $key => $value)
        {
            if ( $years[$key] == $selYear )
            {
                echo '<option selected>',$years[$key],'</option>';
            }
            else
            {
                echo '<option>',$years[$key],'</option>';
            }
        }
        ?>
    </select>
    
    month
    <select name="month" onchange="headerForm.submit();">
        <option value="00">all</option>
        <?php
        $months = $crud->getMonths($selYear);
        $monthFound = false;
        foreach ($months as $key => $value)
        {
            if ( $months[$key]['num'] == $selMonth )
            {
                echo '<option value="',$months[$key]['num'],'" selected>',$months[$key]['month'],'</option>';
                $monthFound = true;
            }
            else
            {
                echo '<option value="',$months[$key]['num'],'">',$months[$key]['month'],'</option>';
            }
        }
        ?>
    </select>
    </header>
    </form>
    
        <?php 
            if ($selMonth == 12) //rollover to january
            {
                $nextMonth = 1;
                $nextYear = $selYear + 1;
            }
            else if ($selMonth == "00")
            {
                $nextMonth = "00";
                $nextYear = $selYear + 1;
            }
            else
            {
                $nextMonth = $selMonth + 1;
                $nextYear = $selYear;
            }
            
            if (!$monthFound)
            {
                $selMonth = "00";
                $nextMonth = "01";
                $nextYear = $selYear + 1;
            }
            
            $theDate = $selYear."-".$selMonth."-01";
            $nextDate = $nextYear."-".$nextMonth."-01";
            
            if ($selMonth == "00")
            {
                $plus1 = $selMonth + 1;
                $theDate = $selYear."-".$plus1."-01";
                $transactions = $crud->getTransactions($theDate, $nextDate);
            }
            else
            {
                $transactions = $crud->getTransactions($theDate, $nextDate);
            }            
            ?>
        
        <form name="tableForm" action="#" method="post">
            
            <?php
            //output to table
            echo '<div class="historyTableDiv">';
            echo '<table class="sortable historyTable">';
            echo '<tr>';
            echo '<th><p>year</p></th>';
            echo '<th><p>month</p></th>';
            echo '<th><p>day</p></th>';
            echo '<th><p>weekday</p></th>';
            echo '<th><p>amount</p></th>';
            echo '<th><p>note</p></th>';
            echo '<th><p>category</p></th>';
            echo '<th><p>delete</p></th>';
            echo '</tr>';
            
            foreach ($transactions as $key => $value)
            {
                echo '<tr>';
                echo '<td>',$transactions[$key]['year'],'</td>';
                echo '<td sorttable_customkey="',$transactions[$key]['monthID'],'">',$transactions[$key]['month'],'</td>';
                echo '<td>',$transactions[$key]['day'],'</td>';
                echo '<td sorttable_customkey="',$transactions[$key]['dayID'],'">',$transactions[$key]['weekday'],'</td>';
                echo '<td>',$transactions[$key]['amount'],'</td>';
                echo '<td>',$transactions[$key]['note'],'</td>';
                echo '<td>',$transactions[$key]['category'],'</td>';
                echo '<td><input type="checkbox" name="id[',$transactions[$key]['id'],']" value="',$transactions[$key]['id'],'"></td>';
                echo '</tr>';
            }
            echo '</table></div>';
            echo '<input type="submit" name="delete" value="delete" class="multiDelete" onclick="return confirm(\'delete transactions?\');" />';
        ?>
            
        </form>
            
    </div>


<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript" src="js/sorttable.js"></script>
</body>
</html>
