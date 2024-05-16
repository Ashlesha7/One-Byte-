<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $id;
    public $username;
    public $password;
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // signup user
    function signup(){
    
        if($this->isAlreadyExist()){
            return false;
        }
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    username=:username, password=:password, created=:created";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":created", $this->created);
    
        // execute query
        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }
    
        return false;
        
    }
    // login user
    /*function login(){
        // select all query
        $query = "SELECT
                    `id`, `username`, `password`, `created`
                FROM
                    " . $this->table_name . " 
                WHERE
                    username='".$this->username."' AND password='".$this->password."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }
    function isAlreadyExist(){
        $query = "SELECT *
            FROM
                " . $this->table_name . " 
            WHERE
                username='".$this->username."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }*/
        // login user


        /*
function login($password) {
    // Select query
    $query = "SELECT `id`, `username`, `password` FROM " . $this->table_name . " WHERE username = :username";

    echo $query;
    // Prepare query statement
    $stmt = $this->conn->prepare($query);

    // Bind parameter
    $stmt->bindParam(":username", $this->username);

    // Execute query
    $stmt->execute();

    // Check if user exists
    if ($stmt->rowCount() > 0) {
        // Get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stored_password = base64_decode($row['password']);
       
        // Verify hashed password
        if ($password === $stored_password) {            
            return true; // Passwords match
        }
    }

    return false; // Either user doesn't exist or passwords don't match
}
*/
function login($password) {
    // Select query
    $query = "SELECT `id`, `username`, `password` FROM " . $this->table_name . " WHERE username = :username";

    // Prepare query statement
    $stmt = $this->conn->prepare($query);

    // Bind parameter
    $stmt->bindParam(":username", $this->username);

    // Execute query
    $stmt->execute();

    // Check if user exists
    if ($stmt->rowCount() > 0) {
        // Get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stored_password = $row['password'];

        // Verify password
        if ($password === $stored_password) {            
            return true; // Passwords match
        }
    }

    return false; // Either user doesn't exist or passwords don't match
}


    function isAlreadyExist() {
        // Select query
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = :username";

        // Prepare query statement
        $stmt = $this->conn->prepare($query);

        // Bind parameter
        $stmt->bindParam(":username", $this->username);

        // Execute query
        $stmt->execute();

        // Check if the username exists
        if ($stmt->rowCount() > 0) {
            return true; // Username already exists
        } else {
            return false; // Username does not exist
        }
    }
}
?>
