<?php

/**
 * Description of DB
 *
 * creates and terminates connection
 * to MySQL server
 * 
 * @author ryan
 */
class DB {

    protected $db = null;
    
    /*
     * create a connection to the db if possible
     * and null it out if not possible
     */
    public function setDB()
    {
        try
        {
            $this->db = new PDO("mysql:host=localhost;port=3306;dbname=sparechange", "sparechange", "sparechange");
            //$this->db = new PDO("mysql:host=mysql5.000webhost.com;port=3306;dbname=a5957278_sparech", "a5957278_sparech", "sparechange9019");
        }        
        catch (Exception $ex)
        {
            $this->closeDB();
        }
    }
    
    public function getDB()
    {
        return $this->db;        
    }
    
    public function closeDB()
    {
        $this->db = null;        
    }
    
}//end class
