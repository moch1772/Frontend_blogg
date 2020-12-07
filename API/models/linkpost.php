<?php

Class Link{
    //DB Stuff
    private $conn;
    private $table = 'comment';

    //Post Properties
    public $pText;
    public $serviceTitle;

    //Constructor with db
    public function __construct($db){
    $this->conn = $db;
    }

    public function read_text(){
        //Create query
        $query = 'SELECT pText FROM post INNER JOIN service WHERE service.serviceTitle = post.pText';
        //Preparing statement
        $stmt = $this->conn->prepare($query);
        //Executing query
        $stmt->execute();

        return $stmt;
    }
}
?>