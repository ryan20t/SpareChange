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
    
    /**
     * validates old password before changing to new one
     * 
     * @param string $oldPW
     * 
     * @return boolean
     */
    public function passwordChangeCorrect($oldPW)
    {
        $id = $_SESSION['id'];
        $selectedPW = null;
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('select password from users where user_id = :id');
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
        }
        
        if ( $dbPrep->execute() && $dbPrep->rowCount() > 0 )
        {
            $selectedPW = $dbPrep->fetch(PDO::FETCH_COLUMN);
        }
        else
        {
            $error = $dbPrep->errorInfo();
            error_log("\n".$error[2], 3, "logs/errors.log");
        }
        
        if ( $selectedPW === sha1($oldPW) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * updates password in DB
     * 
     * @param string $newPW
     * 
     * @return boolean
     */
    public function changePW($newPW)
    {
        $id = $_SESSION['id'];
        $pw = sha1($newPW);
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('update users set password = :pw where user_id = :id');
            
            $dbPrep->bindParam(':pw', $pw, PDO::PARAM_STR);
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
            
            if ( $dbPrep->execute() && $dbPrep->rowCount() > 0 )
            {
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
    
    /**
     * deletes account completely
     * 
     * @return boolean
     */
    public function deleteAccount()
    {
        $id = $_SESSION['id'];
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('delete from users where user_id = :id');  
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
        }
        
        if ( $dbPrep->execute() && $dbPrep->rowCount() > 0 )
        {
            unset($_SESSION['id']);
            return true;
        }
        else
        {
            $error = $dbPrep->errorInfo();
            error_log("\n".$error[2], 3, "logs/errors.log");
            return false;
        }
    }
    
}//end class