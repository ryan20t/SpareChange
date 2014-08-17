<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ErrorLog
 *
 * @author ryan
 */
class ErrorLog {
    
    private $errors = array();
    
    function __construct()
    {
        
    }
    
    
    public function getErrors() {
        return $this->errors;
    }

    public function setErrors($key, $message) {
        $this->errors[$key] = $message;
    }


}
