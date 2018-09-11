<?php

class Category {
    // DB stuff 
    private $conn;
    private $table = 'categories';

    //properties
    public $id;
    public $name;
    public $created_at;

    //constructor;
    public function __construct($db) {
        $this->conn = $db;
    }

    //Get Category
    public function read() {
        //create query
        $query = 'SELECT
           id,
           name
        FROM 
            ' . $this->table.' c
        ORDER BY
            created_at DESC';

        //prepare statement
        $stmt = $this->conn->prepare($query);


        //execute query
        $stmt->execute();
        return $stmt;
    }

    //Getting single category
    public function read_single(){
        $query = 'SELECT
            id,
            name
        FROM 
            ' . $this->table.'
        WHERE 
            id = ?
        LIMIT 0,1';

        $stmt = $this->conn->prepare($query);

        //binding id
        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //setting properites
        $this->id = $row['id'];
        $this->name = $row['name'];
        return $stmt;
    }

    //create category
    public function create() {
        //create post query

        $query = 'INSERT INTO ' . $this->table . '
            SET
                name = :name';
                
        //preparing statement
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));

        //binding data
        $stmt->bindParam(':name', $this->name);
        
        if($stmt->execute()) {
            return true;    
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    //Update category
    public function update() {
        //create post query

        $query = 'UPDATE ' . 
                $this->table . '
            SET
                name = :name
            WHERE 
                id = :id';
                
        //preparing statement
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //binding data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);
        
        if($stmt->execute()) {
            return true;    
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete Catgory
    public function delete() {
        //delete query
        $query = 'DELETE FROM ' . $this->table. ' WHERE id = :id';
        //preparing statement
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;    
        }
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}