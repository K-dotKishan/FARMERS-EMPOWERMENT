<?php
require_once 'config/database.php';

class User {
    private $conn;
    private $table_name = "users";
    private $error_message = "";

    public $id;
    public $username;
    public $email;
    public $password;
    public $full_name;
    public $phone;
    public $address;

    public function __construct() {
        try {
            $database = new Database();
            $this->conn = $database->getConnection();
        } catch (Exception $e) {
            $this->error_message = "Database connection failed: " . $e->getMessage();
            error_log($this->error_message);
        }
    }

    public function getErrorMessage() {
        return $this->error_message;
    }

    public function register() {
        try {
            $query = "INSERT INTO " . $this->table_name . "
                    (username, email, password, full_name, phone, address)
                    VALUES
                    (:username, :email, :password, :full_name, :phone, :address)";

            $stmt = $this->conn->prepare($query);

            // Sanitize input
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
            $this->full_name = htmlspecialchars(strip_tags($this->full_name));
            $this->phone = htmlspecialchars(strip_tags($this->phone));
            $this->address = htmlspecialchars(strip_tags($this->address));

            // Bind values
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":full_name", $this->full_name);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":address", $this->address);

            if($stmt->execute()) {
                return true;
            }
            
            $this->error_message = "Failed to execute query: " . implode(" ", $stmt->errorInfo());
            error_log($this->error_message);
            return false;
        } catch (PDOException $e) {
            $this->error_message = "Database error: " . $e->getMessage();
            error_log($this->error_message);
            return false;
        }
    }

    public function login() {
        $query = "SELECT id, username, password, full_name, email
                FROM " . $this->table_name . "
                WHERE email = :email
                LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->full_name = $row['full_name'];
                return true;
            }
        }
        return false;
    }

    public function checkEmailExists() {
        try {
            $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            $this->error_message = "Database error: " . $e->getMessage();
            error_log($this->error_message);
            return false;
        }
    }

    public function checkUsernameExists() {
        try {
            $query = "SELECT id FROM " . $this->table_name . " WHERE username = :username LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":username", $this->username);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            $this->error_message = "Database error: " . $e->getMessage();
            error_log($this->error_message);
            return false;
        }
    }
}
?> 