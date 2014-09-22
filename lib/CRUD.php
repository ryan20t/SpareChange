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
     * @param string $t transaction model
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
            $dbPrep = $this->getDB()->prepare('insert into transactions set user_id = :id, thedate = :thedate, amount = :amount, category = :category, note = :note');
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
            $dbPrep->bindParam(':thedate', $date, PDO::PARAM_STR);
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
     * delete a single transaction from the database
     * 
     * @param int $tid transaction ID from query string
     * 
     * @return boolean
     */
    public function deleteTransaction($tid)
    {
        $successful = false;
        $userID = $_SESSION['id'];
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('delete from transactions where trans_id = :tid and user_id = :userid');
            
            $dbPrep->bindParam(':tid', $tid, PDO::PARAM_INT);
            $dbPrep->bindParam(':userid', $userID, PDO::PARAM_INT);
            
            if ( $dbPrep->execute() && $dbPrep->rowCount() > 0 )
            {
                $successful = true;
            }
            else
            {
                $error = $dbPrep->errorInfo();
                error_log("\n".$error[2], 3, "logs/errors.log");
            }
        }
        return $successful;
    }//end deleteTransaction()
    
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
            $dbPrep = $this->getDB()->prepare('select bill_name from bills where user_id = :id and bill_type = "budget"');
            
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
    
    /**
     * Get today's non-budget transactions for display on main page
     * 
     * @return array
     */
    public function getToday()
    {
        $today = array();
        $id = $_SESSION['id'];
        $date = date("Y-m-d");
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('select trans_id, amount, note from transactions where user_id = :id and thedate = :date and note is not null');
            
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
    
    /**
     * returns array of bills (name, amount, frequency)
     * 
     * @return array $bills
     */
    public function getBills()
    {
        $id = $_SESSION['id'];
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('select bill_id, bill_name, amount, frequency, bill_type from bills where user_id = :id order by bill_type desc');
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
            
            if ( $dbPrep->execute() && $dbPrep->rowCount() > 0 )
            {
                $bills = $dbPrep->fetchAll(PDO::FETCH_ASSOC);
                return $bills;
            }
            else
            {
                $error = $dbPrep->errorInfo();
                error_log("\n".$error[2], 3, "logs/errors.log");
                return $bills;
            }
        }
    }//end getBills()
    
    /**
     * insert income information
     * 
     * @param decimal $amount
     * @param int $frequency
     * 
     * @return boolean
     */
    public function updateIncome($amount, $frequency)
    {
        $id = $_SESSION['id'];
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('insert into income set user_id = :id, amount = :amount, frequency = :freq on duplicate key update amount = :amount, frequency = :freq');
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
            $dbPrep->bindParam(':amount', $amount, PDO::PARAM_STR);
            $dbPrep->bindParam(':freq', $frequency, PDO::PARAM_INT);
            
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
     * delete income
     */
    
    /**
     * returns array with amount and frequency of income
     * 
     * @return array $income
     */
    public function getIncome()
    {
        $id = $_SESSION['id'];
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('select amount, frequency from income where user_id = :id limit 1');
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
            
            if ( $dbPrep->execute() && $dbPrep->rowCount() > 0 )
            {
                $income = $dbPrep->fetch(PDO::FETCH_ASSOC);
            }
            else
            {
                $income = null;
                $error = $dbPrep->errorInfo();
                error_log("\n".$error[2], 3, "logs/errors.log");
            }
        }
        return $income;
    }//end getIncome()
 
    /**
     * insert a new bill into the table
     * 
     * @param array $bill
     * 
     * @return boolean
     */
    public function insertBill( $bill = array() )
    {
        $id = $_SESSION['id'];
        $billName = $bill['billName'];
        $type = $bill['billType'];
        $amount = $bill['amount'];
        $freq = $bill['frequency'];
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('insert into bills set user_id = :id, bill_name = :billName, bill_type = :billType, amount = :amount, frequency = :freq');
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
            $dbPrep->bindParam(':billName', $billName, PDO::PARAM_STR);
            $dbPrep->bindParam(':billType', $type, PDO::PARAM_STR);
            $dbPrep->bindParam(':amount', $amount, PDO::PARAM_STR);
            $dbPrep->bindParam(':freq', $freq, PDO::PARAM_INT);
            
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
     * delete a single bill from the database
     * 
     * @param int $bid bill ID from query string
     * 
     * @return boolean
     */
    public function deleteBill($bid)
    {
        $successful = false;
        $userID = $_SESSION['id'];
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('delete from bills where bill_id = :bid and user_id = :userid');
            
            $dbPrep->bindParam(':bid', $bid, PDO::PARAM_INT);
            $dbPrep->bindParam(':userid', $userID, PDO::PARAM_INT);
            
            if ( $dbPrep->execute() && $dbPrep->rowCount() > 0 )
            {
                $successful = true;
            }
            else
            {
                $error = $dbPrep->errorInfo();
                error_log("\n".$error[2], 3, "logs/errors.log");
            }
        }
        return $successful;
    }//end deleteTransaction()
    
    /**
     * returns savings goal information
     * 
     * @return array $goal
     */
    public function getGoal()
    {
        $id = $_SESSION['id'];
        $goal = null;
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('select goal_name, amount from goals where user_id = :id');
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
        }
        
        if ( $dbPrep->execute() && $dbPrep->rowCount() > 0 )
        {
            $goal = $dbPrep->fetch(PDO::FETCH_ASSOC);
            return $goal;
        }
        else
        {
            $error = $dbPrep->errorInfo();
            error_log("\n".$error[2], 3, "logs/errors.log");
            return $goal;
        }
    }
    
    /**
     * adds goal to database
     * 
     * @param decimal $amount
     * @param string $name
     * 
     * @return boolean
     */
    public function addGoal($name, $amount)
    {
        $id = $_SESSION['id'];
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('insert into goals set user_id = :id, goal_name = :name, amount = :amount, target = null on duplicate key update goal_name = :name, amount = :amount');
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
            $dbPrep->bindParam(':name', $name, PDO::PARAM_STR);
            $dbPrep->bindParam(':amount', $amount, PDO::PARAM_STR);
        }
        
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
    
    /**
     * remove goal
     * 
     * @return boolean
     */
    public function removeGoal()
    {
        $id = $_SESSION['id'];
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('delete from goals where user_id = :id; delete from transactions where user_id = :id and category = "savings"');
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
        }
        
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
    
    /**
     * get goal current total
     * 
     * @return decimal $total
     */
    public function getGoalTotal()
    {
        $id = $_SESSION['id'];
        $total = null;
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('select sum(amount) from transactions where user_id = :id and category = "savings"');
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
        }
        
        if ( $dbPrep->execute() && $dbPrep->rowCount() > 0 )
        {
            $total = $dbPrep->fetch(PDO::FETCH_COLUMN);
        }
        else
        {
            $error = $dbPrep->errorInfo();
            error_log("\n".$error[2], 3, "logs/errors.log");
        }
        return $total;
    }
    
    /**
     * get unique years from database
     * 
     * @return array $years
     */
    public function getYears()
    {
        $id = $_SESSION['id'];
        $years = array();
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('select distinct(year(thedate)) as year from transactions where user_id = :id order by year desc');
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
        }
        
        if ( $dbPrep->execute() && $dbPrep->rowCount() > 0 )
        {
            $years = $dbPrep->fetchall(PDO::FETCH_COLUMN);
        }
        else
        {
            $error = $dbPrep->errorInfo();
            error_log("\n".$error[2], 3, "logs/errors.log");
        }
        return $years;
    }
    
    /**
     * get unique months from database
     * 
     * @param int $year to get transactions from months in that year
     * 
     * @return array $months
     */
    public function getMonths($year)
    {
        $id = $_SESSION['id'];
        $months = array();
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('select distinct(monthname(thedate)) as month, month(thedate) as num from transactions where user_id = :id and year(thedate) = :year order by num desc');
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
            $dbPrep->bindParam(':year', $year, PDO::PARAM_INT);
        }
        
        if ( $dbPrep->execute() && $dbPrep->rowCount() > 0 )
        {
            $months = $dbPrep->fetchall(PDO::FETCH_ASSOC);
        }
        else
        {
            $error = $dbPrep->errorInfo();
            error_log("\n".$error[2], 3, "logs/errors.log");
        }
        return $months;
    }
    
    /**
     * get transactions from DB
     * 
     * @param int $startDate
     * @param int $endDate
     * 
     * @return array $transactions
     */
    public function getTransactions($startDate, $endDate)
    {
        $id = $_SESSION['id'];
        $transactions = array();
        
        if ( null !== $this->getDB() )
        {
            $dbPrep = $this->getDB()->prepare('select trans_id as id, year(thedate) as year, monthname(thedate) as month, month(thedate) as monthID, day(thedate) as day, dayname(thedate) as weekday, weekday(thedate) as dayID, amount, note, category from transactions where user_id = :id and thedate >= :startDate and thedate < :endDate order by year desc, monthID desc, day desc');
            
            $dbPrep->bindParam(':id', $id, PDO::PARAM_INT);
            $dbPrep->bindParam(':startDate', $startDate, PDO::PARAM_STR);
            $dbPrep->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        }
        
        if ($dbPrep->execute() && $dbPrep->rowCount() > 0)
        {
            $transactions = $dbPrep->fetchall(PDO::FETCH_ASSOC);
        }
        else
        {
            $error = $dbPrep->errorInfo();
            error_log("\n".$error[2], 3, "logs/errors.log");
        }
        
        return $transactions;
    }
}
