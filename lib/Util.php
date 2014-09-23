<?php

/**
 * Description of Util
 *
 * @author ryan
 */
class Util {
    /**
    * A static method to check if a Post request has been made.
    *    
    * @return boolean
    */    
    public static function isPostRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
    }
    
    /**
    * A static method to check if a Get request has been made.
    *    
    * @return boolean
    */    
    public static function isGetRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET' );
    }
    
    /**
     * A static redirect method
     * 
     * @param page name $page to redirect to
     */
    public static function redirect($page)
    {
        header("location: $page.php");
        die();
    }
    
    /**
     * A static function to confirm access granted
     * upon successful login
     */
    public static function confirmAccess() {
        if ( !isset($_SESSION['id']) || !$_SESSION['id'] ) {
           Util::redirect('login');
        }
    }
    
    /**
     * A static function to log out and destroy the session
     */
    public static function checkLogout() {        
        $logout = filter_input(INPUT_GET, 'logout');
        if ( $logout == 1 ) {
           $_SESSION['id'] = null;
            session_destroy();
        }
    }
    
    /**
     * Convert date to DB friendly format
     * 
     * @param string $dateString date as string
     * 
     * @return date $dbDate formatted for Database
     */
    public static function toDBDate($dateString)
    {
        try
        {
            $date = new DateTime($dateString);
            $dbDate = date_format($date, "Y-m-d");
            return $dbDate;
        }
        catch (Exception $e)
        {
            
        }
    }
    
    /**
     * Convert date to display format
     * 
     * @param date $dbDate from database
     * 
     * @return date $displayDate formatted for user
     */
    public static function toDisplayDate($dbDate)
    {
        $date = new DateTime($dbDate);
        $displayDate = date_format($date, "m/d/Y");
        return $displayDate;
    }
    
    /**
     * takes in an amount and it's frequency (occurrences per year) and returns
     * the amount at the desired frequency
     * 
     * @param decimal $amount original amount
     * @param int $freq original frequency
     * @param int $toFreq desired frequency (365 = daily, 52 = weekly, 12 = monthly, 1 = annually)
     * 
     * @return decimal
     */
    public static function toDesiredFrequency($amount, $freq, $toFreq)
    {
        return round( ( $amount * $freq ) / $toFreq, 2 );
    }
    
    /**
     * takes in an integer value, occurrences per year of a payment, and return
     * a literal description of frequency
     * 
     * @param int $freqInt
     * 
     * @return string $freqStr
     */
    public static function displayFrequency($freqInt)
    {
        $freqStr = "";
        
        switch ($freqInt)
        {
            case 365:
                $freqStr = "daily";
                break;
            
            case 52:
                $freqStr = "weekly";
                break;
                
            case 12:
                $freqStr = "monthly";
                break;
                
            case 1:
                $freqStr = "annually";
                break;
            
            default:
                $freqStr = "error: unknown frequency";
                break;
       }
        return $freqStr;
    }
    
    /**
     * get percentage
     * 
     * @param decimal $total
     * @param decimal $runningTotal
     * 
     * @return decimal $percent
     */
    public static function getPercent($total, $runningTotal)
    {
        if ($total == 0)
        {
            return 0;
        }
        try
        {
            $percent = round(100 * ($runningTotal / $total), 1);
            return $percent;
        }
        catch (Exception $ex)
        {
            $percent = 0;
            return $percent;
        }
    }
    
}//end class