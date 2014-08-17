<?php

/**
 * Description of TransactionModel
 *
 * @author ryan
 */
class TransactionModel {
    
    private $id;
    private $date;
    private $amount;
    private $category;
    private $note;
    
    function __construct( $type, $data = array() )
    {
        $this->map($type, $data);
    }
    
    //Mapping function
    public function map($type, $data)
    {
        if ( !is_array($data) )
        {
            return false;
        }
        
        $this->setId($_SESSION['id']);
        
        if ( array_key_exists('date', $data ) )
        {
            $this->setDate(Util::toDBDate($data['date']));
        }
        
        if ( array_key_exists('amount', $data ) )
        {
            $this->setAmount( round($data['amount'], 2) );
        }
        
        if ( array_key_exists('category', $data ) )
        {
            if ( $type === "category" )
            {
                $this->setCategory($data['category']);
            }
            else
            {
                $this->setCategory(null);
            }
        }
        
        if ( array_key_exists('note', $data ) )
        {
            if ( $type === "note" )
            {
                $this->setNote($data['note']);
            }
            else
            {
                $this->setNote(null);
            }
        }
        
    }
    
    //Getters and setters
    public function getId() {
        return $this->id;
    }

    public function getDate() {
        return $this->date;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getNote() {
        return $this->note;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function setNote($note) {
        $this->note = $note;
    }


    
}
