<?php

Class Comment{
    //DB Stuff
    private $conn;
    private $table = 'comment';

    //Post Properties
    public $cText;
    public $cDate;
    public $pageID;
    public $commentID;
    public $cPublish;

    //Constructor with db
    public function __construct($db){
    $this->conn = $db;
    }

    public function read_comment(){
        //Create query
        $query = 'SELECT * FROM comment where cPublish = 1';
        //Preparing statement
        $stmt = $this->conn->prepare($query);
        //Executing query
        $stmt->execute();

        return $stmt;
    }
    
    public function read_page_comment(){
            //Create query
            $query = 'SELECT * FROM comment WHERE pageID =' . $this->pageID . ' and cPublish = 1';
            //Preparing statement
            $stmt = $this->conn->prepare($query);
            //Executing query
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $rows;
    }

    
//Create comment
public function create_comment(){
    //Create query
    $query = 'INSERT INTO ' . $this->table . '
    SET
        cText = :cText,
        cDate = CURDATE(),
        pageID = :pageID,
        commentID = :commentID,
        cPublish = :cPublish';

        //Preparing statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->cText =htmlspecialchars(strip_tags($this->cText));
        $this->cPublish =htmlspecialchars(strip_tags($this->cPublish));
        $this->pageID =htmlspecialchars(strip_tags($this->pageID));


        //Bind data
        $stmt->bindParam(':cText', $this->cText);
        $stmt->bindParam(':pageID', $this->pageID);
        $stmt->bindParam(':cPublish', $this->cPublish);
        $stmt->bindParam(':commentID', $this->commentID);


        //Executing query
        if($stmt->execute()){
            return true;
        }

        //Print error
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

        //Update comment
        public function update_comment(){
            //Update query
            $query = 'UPDATE ' . $this->table . '
            SET
                cText = :cText,
                cDate = CURDATE(),
                pageID = :pageID,
                commentID = :commentID
            WHERE
                commentID = :commentID';
    
                //Preparing statement
                $stmt = $this->conn->prepare($query);
    
                //Clean data
                $this->cText =htmlspecialchars(strip_tags($this->cText));
                $this->pageID =htmlspecialchars(strip_tags($this->pageID));
                $this->commentID =htmlspecialchars(strip_tags($this->commentID));
    
                //Bind data
                $stmt->bindParam(':cText', $this->cText);
                $stmt->bindParam(':pageID', $this->pageID);
                $stmt->bindParam(':commentID', $this->commentID);

                //Executing query
                if($stmt->execute()){
                    return true;
                }
    
                //Print error
                printf("Error: %s.\n", $stmt->error);
                return false;
        }
        //Delete comment
        public function delete_comment(){
            //Creating query
            $query = 'DELETE FROM comment WHERE commentID = :commentID';

            //Preparing statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->commentID =htmlspecialchars(strip_tags($this->commentID));

            //Bind data
            $stmt->bindParam(':commentID', $this->commentID);

            //Executing query
            if($stmt->execute()){
                return true;
            }
            
            //Print error
            printf("Error: %s.\n", $stmt->error);
            return false;
        }


    public function comment_ceo(){
        //Create query
        $query = 'SELECT * FROM comment, user WHERE comment.commentID = commentID AND user.userID = userID';
        //Preparing statement
        $stmt = $this->conn->prepare($query);
        //Executing query
        $stmt->execute();

        return $stmt;
    }

    public function guest_comment(){
        //Create query
        $query = 'SELECT * FROM comment WHERE commentID = commentID';
        //Preparing statement
        $stmt = $this->conn->prepare($query);
        //Executing query
        $stmt->execute();

        return $stmt;
    }

    //Create Comment
    public function moderator_comment(){
        //Create query
        $query = 'INSERT INTO ' . $this->table . '
        SET
            cText = :cText,
            cDate = CURDATE(),
            pageID = :pageID,
            commentID = :commentID,
            cPublish = :cPublish';

            //Preparing statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->cText =htmlspecialchars(strip_tags($this->cText));
            $this->cDate =htmlspecialchars(strip_tags($this->cDate));
            $this->pageID =htmlspecialchars(strip_tags($this->pageID));
            $this->commentID =htmlspecialchars(strip_tags($this->commentID));
            $this->cPublish =htmlspecialchars(strip_tags($this->cPublish));

            //Bind data
            $stmt->bindParam(':cText', $this->cText);
            $stmt->bindParam(':cDate', $this->cDate);
            $stmt->bindParam(':pageID', $this->pageID);
            $stmt->bindParam(':commentID', $this->commentID);
            $stmt->bindParam(':cPublish', $this->cPublish);
           

            //Executing query
            if($stmt->execute()){
                return true;
            }

            //Print error
            printf("Error: %s.\n", $stmt->error);
            return false;
    }

    //Delete comment
        public function deny_comment(){
            //Creating query
            $query = 'DELETE FROM comment 
            WHERE commentID = :commentID';

            //Preparing statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->commentID =htmlspecialchars(strip_tags($this->commentID));

            //Bind data
            $stmt->bindParam(':commentID', $this->commentID);

            //Executing query
            if($stmt->execute()){
                return true;
            }
            
            //Print error
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
        
        //Update allowComments BOOL to TRUE
        public function activate_comment(){
            if(isset($_POST['comment_activate_btn'])){
            $query = 'UPDATE ' . $this->table . 'SET allowComments = ?';
    
                //Preparing statement
                $stmt = $this->conn->prepare($query);
    
                //Clean data
                $this->publish = htmlspecialchars(strip_tags($this->publish));
    
                //Bind data
                $stmt->bindParam(1, $this->publish);
    
                //Executing query
                if($stmt->execute()){
                    return true;
                }
    
                //Print error
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }
        //Update allowComments BOOL to FALSE
        public function deactivate_comment(){
            if(isset($_POST['comment_deactivate_btn'])){
            $query = 'UPDATE ' . $this->table . 'SET allowComments = ?';
    
                //Preparing statement
                $stmt = $this->conn->prepare($query);
    
                //Clean data
                $this->publish =htmlspecialchars(strip_tags($this->publish));
    
                //Bind data
                $stmt->bindParam(0, $this->publish);
    
                //Executing query
                if($stmt->execute()){
                    return true;
                }
    
                //Print error
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }

}


Class Comment_history{
    //DB Stuff
    private $conn;
    private $table = 'comment';

    //Comment Properties
    public $commentId;
    public $cText;
    public $cDate;
    public $pageID;


    //Constructor with db
    public function __construct($db){
        $this->conn = $db;
    }

    public function read_comment_history(){
        //Create query
        $query = 'SELECT * FROM comment';
        //Preparing statement
        $stmt = $this->conn->prepare($query);
        //Executing query
        $stmt->execute();

        return $stmt;
    }

}

?>