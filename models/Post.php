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
}