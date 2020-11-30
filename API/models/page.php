<?php

Class page{
    //DB Stuff
    private $conn;
    private $table = 'spage';

    //Service Properties
    public $serviceID;
    public $pageID;
    public $metaTag;
    
    //Constructor with db
    public function __construct($db){
        $this->conn = $db;
    }

    
    public function create_page(){
        //Create query
        $query = 'INSERT INTO ' . $this->table . '
        SET
            serviceID = :serviceID,
            metaTag = :metaTag';

            //Preparing statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->serviceID =htmlspecialchars(strip_tags($this->serviceID));
            $this->metaTag =htmlspecialchars(strip_tags($this->metaTag));

            //Bind data
            $stmt->bindParam(':serviceID', $this->serviceID);
            $stmt->bindParam(':metaTag', $this->metaTag);

            //Executing query
            if($stmt->execute()){
                return true;
            }
        }

        public function read_page_service()
        {
            //Create query
            $query = 'SELECT * FROM '. $this->table.' WHERE serviceID = :serviceID';
        //Preparing statement
        $stmt = $this->conn->prepare($query);
            //Clean data
            $this->serviceID =htmlspecialchars(strip_tags($this->serviceID));

            //Bind data
            $stmt->bindParam(':serviceID', $this->serviceID);
        //Executing query
        $stmt->execute();

        return $stmt;
        }

    }