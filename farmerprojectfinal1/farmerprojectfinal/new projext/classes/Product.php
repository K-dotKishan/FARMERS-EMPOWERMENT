<?php
require_once 'config/database.php';

class Product {
    private $conn;
    private $table_name = "products";
    private $images_table_name = "product_images";
    private $error_message = "";

    public $id;
    public $user_id;
    public $name;
    public $description;
    public $category;
    public $price;
    public $quantity;
    public $status;
    public $created_at;

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

    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . "
                    (user_id, name, description, category, price, quantity, status)
                    VALUES
                    (:user_id, :name, :description, :category, :price, :quantity, :status)";

            $stmt = $this->conn->prepare($query);

            // Sanitize input
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->price = htmlspecialchars(strip_tags($this->price));
            $this->quantity = htmlspecialchars(strip_tags($this->quantity));
            $this->status = htmlspecialchars(strip_tags($this->status));

            // Bind values
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":category", $this->category);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":quantity", $this->quantity);
            $stmt->bindParam(":status", $this->status);

            if($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
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

    public function addImage($product_id, $image_path) {
        try {
            $query = "INSERT INTO " . $this->images_table_name . "
                    (product_id, image_path)
                    VALUES
                    (:product_id, :image_path)";

            $stmt = $this->conn->prepare($query);

            // Sanitize input
            $product_id = htmlspecialchars(strip_tags($product_id));
            $image_path = htmlspecialchars(strip_tags($image_path));

            // Bind values
            $stmt->bindParam(":product_id", $product_id);
            $stmt->bindParam(":image_path", $image_path);

            return $stmt->execute();
        } catch (PDOException $e) {
            $this->error_message = "Database error: " . $e->getMessage();
            error_log($this->error_message);
            return false;
        }
    }

    public function getProductsByUser($user_id) {
        try {
            $query = "SELECT p.*, u.username as seller_name 
                    FROM " . $this->table_name . " p
                    LEFT JOIN users u ON p.user_id = u.id
                    WHERE p.user_id = :user_id
                    ORDER BY p.created_at DESC";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            $this->error_message = "Database error: " . $e->getMessage();
            error_log($this->error_message);
            return false;
        }
    }

    public function getProductImages($product_id) {
        try {
            $query = "SELECT image_path 
                    FROM " . $this->images_table_name . "
                    WHERE product_id = :product_id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":product_id", $product_id);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            $this->error_message = "Database error: " . $e->getMessage();
            error_log($this->error_message);
            return false;
        }
    }

    public function delete($product_id) {
        try {
            // First delete associated images
            $query = "DELETE FROM " . $this->images_table_name . " WHERE product_id = :product_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":product_id", $product_id);
            $stmt->execute();

            // Then delete the product
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :product_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":product_id", $product_id);

            return $stmt->execute();
        } catch (PDOException $e) {
            $this->error_message = "Database error: " . $e->getMessage();
            error_log($this->error_message);
            return false;
        }
    }
} 