<?php

class Post {
    // DB stuff 
    private $conn;
    private $table = 'posts';

    //properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    //constructor;
    public function __construct($db) {
        $this->conn = $db;
    }

    //Get Post
    public function read() {
        //create query
        $query = 'SELECT
            c.name as cateogry_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
        FROM 
            ' . $this->table.' p
        LEFT JOIN
            categories c on p.category_id = c.id
        ORDER BY
            p.created_at desc';

        //prepare statement
        $stmt = $this->conn->prepare($query);


        //execute query
        $stmt->execute();
        return $stmt;
    }

    //Getting single post
    public function read_single(){
        $query = 'SELECT
            c.name as cateogry_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
        FROM 
            ' . $this->table.' p
        LEFT JOIN
            categories c on p.category_id = c.id
        WHERE 
            p.id = ?
        LIMIT 0,1';

        $stmt = $this->conn->prepare($query);

        //binding id
        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //setting properites
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];


        return $stmt;
    }

    //create post
    public function create() {
        //create post query

        $query = 'INSERT INTO ' . $this->table . '
            SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id';
                
        //preparing statement
        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //binding data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        
        if($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}