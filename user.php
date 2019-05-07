<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "user";
 
    // object properties
    public $u_email;
    public $password;
    public $fname;
    public $lname;
    public $gender;
    public $age;
    public $list_interest;
    public $mob_number;
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
                    u_email=:u_email, password=:password, fname=:fname, lname=:lname, gender=:gender, 
                    age=:age, list_interest=:list_interest, created=:created";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->fname=htmlspecialchars(strip_tags($this->fname));
        $this->lname=htmlspecialchars(strip_tags($this->lname));
        $this->u_email=htmlspecialchars(strip_tags($this->uemail));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->gender=htmlspecialchars(strip_tags($this->gender));
        $this->age=htmlspecialchars(strip_tags($this->age));
        $this->list_interest=htmlspecialchars(strip_tags($this->list_interest));
        $this->mob_number=htmlspecialchars(strip_tags($this->mob_number));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values
        $stmt->bindParam(":fname", $this->fname);
        $stmt->bindParam(":lname", $this->lname);
        $stmt->bindParam(":u_email", $this->u_email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":gender", $this->gender);
        $stmt->bindParam(":age", $this->age);
        $stmt->bindParam(":list_interest", $this->list_interest);
        $stmt->bindParam(":mob_number", $this->mob_number);
        $stmt->bindParam(":created", $this->created);
    
        // execute query
        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }
    
        return false;
        
    }

    // login user
    function login(){
        // select all query
        $query = "SELECT
                    `u_email`, `password`, `created`
                FROM
                    " . $this->table_name . " 
                WHERE
                    u_email='".$this->u_email."' AND password='".$this->password."'";

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
                u_email='".$this->u_email."'";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}