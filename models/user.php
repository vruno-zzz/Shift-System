<?php

//create a class with the name "User"
    class customer { 
        private $conn;
            public function __construct($conexion) {
                $this->conn =  $conexion;
            }
        //in this section we create the user_model
            public function create($name, $email, $password){
                $sql = "INSERT INTO usuarios (name, email, pass) VALUES (?, ?, ?)";   
                $stmt = $this->conn->prepare($sql);
                return $stmt->execute([$name, $email, $password]);
            }

        //here we add the function for searching user with their email
            public function searchEmail($email) {
                $sql = "SELECT * FROM customer WHERE email = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$email]);
                return $stmt->fetch();
            }

    }