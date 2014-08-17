<?php

/**
 * Description of signupLogin
 *
 * functions for signing up and
 * logging into spare change
 * 
 * @author ryan
 */
class SignupLogin extends DB {
    
    public function __construct()
    {
        $this->setDB();
    }
    
    /**
     * function to create user entry in DB and return user ID
     * 
     * @param string $email must be valid email
     * @param string $password must be valid password
     * @param string $date must be todays date formatted for DB
     * 
     * @return int
     */
    public function saveSignup($email, $password, $date)
    {
        $result = false;
        $insertPW = sha1($password);
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('insert into users set email = :email, password = :password, signup_date = :date');
            
            $dbPrep->bindParam(':email', $email, PDO::PARAM_STR);
            $dbPrep->bindParam(':password', $insertPW, PDO::PARAM_STR);
            $dbPrep->bindParam(':date', $date, PDO::PARAM_STR);
            
            if ( $dbPrep->execute() && $dbPrep->rowCount() > 0 )
            {
                $result = intval( $this->getDB()->lastInsertId() );
                $_SESSION['id'] = $result;
            }
            else
            {
                $error = $dbPrep->errorInfo();
                error_log("\n".$error[2], 3, "logs/errors.log");
            }
        }
        
        return $result;
        
    }
    
    /**
     * login function
     * 
     * @param string $email must be a vaild, registered email
     * @param string $password must be a valid password format
     * 
     * @return bool
     */
    public function loginIsCorrect($email, $password)
    {
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('select user_id, password from users where email = :email limit 1');
            $dbPrep->bindParam(':email', $email, PDO::PARAM_STR);
            
            if ( $dbPrep->execute() & $dbPrep-rowCount > 0 )
            {
                $results = $dbPrep->fetch(PDO::FETCH_ASSOC);
            }
            
            $checkPW = sha1($password);
            
            if ( $results['password'] == $checkPW )
            {
                $_SESSION['id'] = $results['user_id'];
                return true;
            }
            else
            {
                $error = $dbPrep->errorInfo();
                error_log("\n".$error[2], 3, "logs/errors.log");
                return false;
            }
            
        }
    }
    
    
}//end class