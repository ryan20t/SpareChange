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
    
}//end class
