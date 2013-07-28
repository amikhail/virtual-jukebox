<?php

/**
 * @author 
 * @copyright 2013
 */

//TODO: add sql injection protection
//      add exception handling
//      more comments

class Database {
    //private member data
    private $HOST = 'localhost';
    private $USERNAME = 'vj_coder';
    private $PASSWORD = 'vj123';
    private $DATABASE = 'virtual_jukebox';
    
    private $mysqli;
    private $isError = false;
    private $errorMsg = '';    
    private $resultSet = NULL;
    private $lastSqlStmt = '';
    
    //constructor
    function __construct(){
        //initialize
        $this->mysqli = new mysqli($this->HOST, $this->USERNAME, $this->PASSWORD, $this->DATABASE);        
    
        if($this->mysqli->connect_errno){
            $this->isError = true;
            $this->errorMsg = "Failed to connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
        }
    }
    
    //for SELECT
    //returns mysqli_result object on SUCCESS; NULL on FAIL
    public function executeSelect($sqlStmt){
        if($this->mysqli->connect_errno){
            $this->isError = true;
            $this->errorMsg = $this->errorMsg . "<br/>\n[Database class -> executeSelect] Connection error: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
            $this->errorMsg = $this->errorMsg . "<br/>\nUnable to select: " . $sqlStmt;
                        
            $this->resultSet = NULL;
            return $this->resultSet;
        }
        
        $sqlStmt = $this->mysqli->real_escape_string($sqlStmt);
        $this->resultSet = $this->mysqli->query($sqlStmt);
        $this->lastSqlStmt = $sqlStmt;
        return $this->resultSet;
        
        //check to see if query succeeded
        if(!$this->resultSet){
            $this->resultSet = NULL;
            $this->isError = true;
            $this->errorMsg = $this->errorMsg . "<br/>\n[Database class -> executeSelect] SQL Statement failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
            $this->errorMsg = $this->errorMsg . "<br/>\nUnable to select: " . $sqlStmt;
        }
        return $resultSet;
    }
    
    //for INSERT, UPDATE, DELETE
    //returns boolean; true on SUCCESS, false on FAIL
    public function executeStmt($sqlStmt){
        if($this->mysqli->connect_errno){
            $this->isError = true;
            $this->errorMsg = $this->errorMsg . "<br/>\n[Database class -> executeStmt] Connection error: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
            $this->errorMsg = $this->errorMsg . "<br/>\nUnable to select: " . $sqlStmt;
            
            $this->resultSet = NULL;
            return $this->resultSet;
        }
        
        $sqlStmt = $this->mysqli->real_escape_string($sqlStmt);
        $flag = $this->mysqli->query($sqlStmt);
        $this->lastSqlStmt = $sqlStmt;
        
        //check to see if query succeeded
        if(!$flag){
            $this->isError = true;
            $this->errorMsg = $this->errorMsg . "<br/>\n[Database class -> executeStmt] SQL Statement failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
            $this->errorMsg = $this->errorMsg . "<br/>\nUnable to execute: " . $sqlStmt;
        }
        return $flag;
    }
    
    public function isError(){
        return $this->isError;
    }
    
    public function getErrorMsg(){
        return $this->errorMsg;
    }
    
    public function startTransaction(){
        $this->mysqli->autocommit(FALSE);
        $this->executeSelect('START TRANSACTION');
    }
    
    public function commitTransaction(){
        $this->mysqli->commit();
    }
    
    public function rollbackTransaction(){
        $this->mysqli->rollback();
    }
    
    public function escapeString(){
        return $mysqli->real_escape_string();
    }
       
    //dumps class instance to screen
    public function debug(){
        var_dump($this);
    }
    
    public function getLastSqlStmt(){
        return $this->lastSqlStmt;
    }
    
    //destructor
    function __destruct(){
        //clean-up
        (!$this->resultSet) or $this->resultSet->close();
        (!$this->mysqli || !$this->mysqli->connect_errno) or $this->mysqli->close();
    }
}
?>