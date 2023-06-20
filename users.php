<?php
// include 'db_config.php';

class Users {
    public $conn;
    public $user_i;

    function __construct($conn) {
        $this->conn = $conn;
    }

    function create($username, $password) {
        $sql_du = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $sql_us = "INSERT INTO users (username, password) 
                   VALUES ('$username', '$password')";
        

        $result = $this->conn->query($sql_du);
        if ($result === false) {
            echo "Error occurred: " . $this->conn->error;
            return false;
        } elseif ($result->num_rows > 0) {
            echo "<br>Username already exists";
            $user = $result->fetch_assoc();
            $this->user_i = $user["id"];
            // echo $this->user_i;
            return $this->user_i;

        } else {
            if ($this->conn->query($sql_us) === true) {
                $this->user_i = $this->conn->insert_id;
                echo "<br> User created successfully";
                // echo $this->user_i;
                return $this->user_i;
            } else {
                echo "Error occurred during user insertion: " . $this->conn->error;
                return false;
            }
        }
    }
    
    function selectUserN($username , $password) {
        $sql_du = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $this->conn->query($sql_du);
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $this->user_i = $user["id"];
            return $this->user_i;
        } else {
            return null;
        }
    }


    function selectUser($id){
        $sql = "SELECT * FROM users WHERE id = '$id'";
        $result = $this->conn->query($sql);
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $this->id = $user["id"];
            $this->username = $user["username"];
            $this->password = $user["password"];
        }
    }

    function getId() {
        // echo "<br> User's user_i: " . $this->user_i;
        return $this->user_i;
    }
}


// $q = new Users($conn);
// $q->create("haseeb", "ahmed");
// echo $q->SelectUserN("alif");
// $q->selectUser(6);
// echo $q->username;


?>
