<?php

/**
 * Description of ErrorLog
 *
 * @author ryan
 */
class ErrorLog {
    
    protected $errors = array();
    protected $passwordRequirements = array(
        "six character minimum"
    );
    
    public $email;
    public $confirmEmail;
    public $password;
    public $confirmPw;
    public $amount;
    public $description;
    public $frequency;
    
    public function __construct()
    {
        $this->email = filter_input(INPUT_POST, 'email');
        $this->confirmEmail = filter_input(INPUT_POST, 'confirmEmail');
        $this->password = filter_input(INPUT_POST, 'password');
        $this->confirmPw = filter_input(INPUT_POST, 'confirmPw');
        $this->amount = filter_input(INPUT_POST, 'amount');
        $this->description = filter_input(INPUT_POST, 'billName');
        $this->frequency = filter_input(INPUT_POST, 'frequency');
    }
    
    //getters
    public function getErrors() {
        return $this->errors;
    }
    
    public function getPasswordRequirements() {
        return $this->passwordRequirements;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getConfirmEmail() {
        return $this->confirmEmail;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getConfirmPw() {
        return $this->confirmPw;
    }
    
    public function getAmount() {
        return $this->amount;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function getFrequency() {
        return $this->frequency;
    }

    //test a complete sign up or login for validity
    public function loginValid()
    {
        $this->emailIsValid();
        $this->passwordIsValid();
        return ( count($this->errors) ? false : true );
    }
    
    public function signupValid()
    {
        $this->emailIsValid();
        $this->confirmEmailValid();
        $this->passwordIsValid();
        $this->confirmPasswordValid();
        return ( count($this->errors) ? false : true );
    }
    
    //test a complete new bill entry
    public function billValid()
    {
        $this->amountIsValid();
        $this->descriptionIsValid();
        $this->frequencyIsValid();
        return ( count($this->errors) ? false : true );
    }
    
    //test for valid info to change password
    public function pwChangeValid()
    {
        $this->passwordIsValid();
        $this->confirmPasswordValid();
        return ( count($this->errors) ? false : true );
    }
    
    //field specific validation
    public function emailIsValid()
    {
        if ( !IsValid::notEmpty($this->email) ) //no email entered
        {
            $this->errors["email"] = "e-mail required";
        }
        else
        {
            if ( !IsValid::emailIsValid($this->email) )
            {
                $this->errors["email"] = "e-mail is invalid";
            }
        }
    }
    
    public function confirmEmailValid()
    {
        if ( !IsValid::notEmpty($this->confirmEmail) || !IsValid::compare($this->email, $this->confirmEmail) ) //no email confirmation entered or invalid match
        {
            $this->errors["confirmEmail"] = "e-mails do not match";
        }
    }
    
    public function passwordIsValid()
    {
        if ( !IsValid::notEmpty($this->password) ) //no password
        {
            $this->errors["password"] = "password required";
        }
        else
        {
            if ( !IsValid::passwordIsValid($this->password) ) //doesn't meet requirements
            {
                $this->errors["password"] = "invalid password"; //list of requirements in variable
            }
        }
    }
    
    public function confirmPasswordValid()
    {
        if ( !IsValid::notEmpty($this->confirmPw) || !IsValid::compare($this->password, $this->confirmPw) ) //no email confirmation entered or invalid match
        {
            $this->errors["confirmPw"] = "passwords do not match";
        }
    }
    
    public function amountIsValid()
    {
        if ( !IsValid::notEmpty($this->amount) )
        {
            $this->errors["amount"] = "amount required";
        }
        else if ( !$this->amount > 0 )
        {
            $this->errors["amount"] = "$0.00? I wish I had bills like that.";
        }
        else if ( IsValid::isDecimal($this->amount) )
        {
            $this->errors["amount"] = "amount invalid";
        }
    }
    
    public function descriptionIsValid()
    {
        if ( !IsValid::notEmpty($this->description) )
        {
            $this->errors["description"] = "description required";
        }
        else if ( strlen($this->description) > 25 )
        {
            $this->errors["description"] = "description limit 25 characters";
        }
    }
    
    public function frequencyIsValid()
    {
        if ( !IsValid::isValidFrequency($this->frequency) )
        {
            $this->errors["frequency"] = "invalid frequency";
        }
    }
    
}
