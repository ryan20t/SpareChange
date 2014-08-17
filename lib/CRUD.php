<?php

/**
 * Description of CRUD
 *
 * @author ryan
 */
class CRUD extends DB {
    
    public function __construct()
    {
        $this->setDB();
    }
    
    /**
     * function to insert transaction into the database
     * 
     * @param string $t must be valid email
     * 
     * @return bool
     */
    public function insertTransaction(TransactionModel $t)
    {
        $success = false;
        
        $id = $t->getId();
        $date = $t->getDate();
        $amount = $t->getAmount();
        $category = $t->getCategory();
        $note = $t->getNote();
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('insert into transactions set user_id = :id, thedate = :date, amount = :amount, category = :category, note = :note');
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
            $dbPrep->bindParam(':date', $date, PDO::PARAM_STR);
            $dbPrep->bindParam(':amount', $amount, PDO::PARAM_STR);
            if ( null === $category )
            {
                $dbPrep->bindParam(':category', $category, PDO::PARAM_NULL);
                $dbPrep->bindParam(':note', $note, PDO::PARAM_STR);
            }
            else if ( null === $note )
            {
                $dbPrep->bindParam(':category', $category, PDO::PARAM_STR);
                $dbPrep->bindParam(':note', $note, PDO::PARAM_NULL);                
            }
            
            if ( $dbPrep->execute() && $dbPrep->rowCount() > 0 )
            {
                $success = true;
            }
            else
            {
                $error = $dbPrep->errorInfo();
                error_log("\n".$error[2], 3, "logs/errors.log");
            }

            return $success;
            
        }
    }//end insertTransaction()
    
    /**
     * pull list of budget categories from DB
     * 
     * @return array
     */
    public function getCategories()
    {
        $categories = array();
        $id = $_SESSION['id'];
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('select bill_name from budget where user_id = :id');
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
            
            if ( $dbPrep->execute() && $dbPrep->rowCount() > 0 )
            {
                $categories = $dbPrep->fetchAll(PDO::FETCH_COLUMN);
                return $categories;
            }
            else
            {
                $categories[0] = 0;
                $error = $dbPrep->errorInfo();
                error_log("\n".$error[2], 3, "logs/errors.log");
                return $categories;
            }
        }
    }//end getCategories()
    
    public function getToday()
    {
        $today = array();
        $id = $_SESSION['id'];
        $date = date("Y-m-d");
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('select amount, note from transactions where user_id = :id and thedate = :date and note is not null');
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
            $dbPrep->bindParam(':date', $date, PDO::PARAM_STR);
            
            if ( $dbPrep->execute() && $dbPrep->rowCount() > 0 )
            {
                $today = $dbPrep->fetchAll(PDO::FETCH_ASSOC);
                return $today;
            }
            else
            {
                $error = $dbPrep->errorInfo();
                error_log("\n".$error[2], 3, "logs/errors.log");
            }
        }
    }//end getToday()
    
}
