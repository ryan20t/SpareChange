<?php

/**
 * Description of isValid
 *
 * @author ryan
 */
class isValid {
    /**
     * Test for empty field
     * 
     * @param value $value
     * 
     * @return boolean
     */
    public static function notEmpty($value)
    {
        if ( $value )
        {
            return true;
        }
        return false;
    }
    
     /**
     * Static email verification method
     * 
     * @param string $email must be a valid email address
     * 
     * @return boolean
     */
    public static function emailIsValid($email) {
        if ( is_string($email) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) != false )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
    * Static method, tests password for proper format
    *
    * @param string $password must be a valid Length
    *
    * @return boolean
    */    
    public static function passwordIsValid($password) {
        //add to this
        if ( is_string($password) && !empty($password) && strlen($password) > 5 )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Static method to compare confirmation fields
     * 
     * @param value1 $value1
     * @param value2 $value2
     * 
     * @return boolean
     */
    public static function compare($value1, $value2)
    {
        if ($value1 === $value2)
        {
            return true;
        }
        else
        {
            return false;            
        }
    }
    
    /**
     * Determine if input is a decimal number
     * 
     * @param number $number
     * 
     * @return boolean
     */
    public static function isDecimal($number)
    {
        if ( is_int($number) || is_float($number) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Determine if input is a valid date
     * 
     * @param string $date
     * 
     * @return boolean
     */
    public static function isDate($date)
    {
        try
        {
            $validDate = new DateTime($date);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}//end class
