<?php
/**
 * User Model
 * This is like your User model/schema in Node.js with Mongoose
 * It defines the structure and operations for the users table
 */

class User {
    private $db;
    private $table = 'users';
    
    // User properties (your schema fields)
    public $id;
    public $fullname;
    public $email;
    public $family_name;
    public $phone_no;
    public $quarters;
    public $current_address;
    public $created_at;
    public $updated_at;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Create a new user
     * Like User.create() in Mongoose
     */
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (fullname, email, family_name, phone_no, quarters, current_address) 
                  VALUES (:fullname, :email, :family_name, :phone_no, :quarters, :current_address)";
        
        $stmt = $this->db->prepare($query);
        
        // Bind parameters (prevents SQL injection)
        $stmt->bindParam(':fullname', $data['fullname']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':family_name', $data['family_name']);
        $stmt->bindParam(':phone_no', $data['phone_no']);
        $stmt->bindParam(':quarters', $data['quarters']);
        $stmt->bindParam(':current_address', $data['current_address']);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    /**
     * Get all users
     * Like User.find() in Mongoose
     */
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get user by ID
     * Like User.findById() in Mongoose
     */
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Alias for getById to match the route usage
     */
    public function findById($id) {
        return $this->getById($id);
    }
    
    /**
     * Search users
     * Like User.find() with search conditions in Mongoose
     */
    public function search($searchTerm) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE fullname LIKE :search 
                  OR family_name LIKE :search 
                  OR email LIKE :search 
                  OR quarters LIKE :search 
                  OR current_address LIKE :search
                  ORDER BY fullname ASC";
        
        $stmt = $this->db->prepare($query);
        $searchParam = "%{$searchTerm}%";
        $stmt->bindParam(':search', $searchParam);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Update user
     * Like User.findByIdAndUpdate() in Mongoose
     */
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET fullname = :fullname, 
                      email = :email, 
                      family_name = :family_name, 
                      phone_no = :phone_no, 
                      quarters = :quarters, 
                      current_address = :current_address,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':fullname', $data['fullname']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':family_name', $data['family_name']);
        $stmt->bindParam(':phone_no', $data['phone_no']);
        $stmt->bindParam(':quarters', $data['quarters']);
        $stmt->bindParam(':current_address', $data['current_address']);
        
        return $stmt->execute();
    }
    
    /**
     * Delete user
     * Like User.findByIdAndDelete() in Mongoose
     */
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    /**
     * Check if email exists
     * Like User.findOne({email}) in Mongoose
     */
    public function emailExists($email, $excludeId = null) {
        $query = "SELECT id FROM " . $this->table . " WHERE email = :email";
        
        if ($excludeId) {
            $query .= " AND id != :excludeId";
        }
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        
        if ($excludeId) {
            $stmt->bindParam(':excludeId', $excludeId);
        }
        
        $stmt->execute();
        return $stmt->fetch() !== false;
    }
    
    /**
     * Validate user data
     * Like schema validation in Mongoose
     */
    public function validate($data, $isUpdate = false, $userId = null) {
        $errors = [];
        
        // Required fields
        $requiredFields = ['fullname', 'email', 'family_name', 'phone_no', 'quarters', 'current_address'];
        
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                $errors[] = "Field '{$field}' is required";
            }
        }
        
        // Email validation
        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }
        
        // Check if email already exists
        if (isset($data['email']) && $this->emailExists($data['email'], $userId)) {
            $errors[] = "Email already exists";
        }
        
        // Phone number basic validation
        if (isset($data['phone_no']) && strlen(trim($data['phone_no'])) < 10) {
            $errors[] = "Phone number must be at least 10 characters";
        }
        
        return $errors;
    }
}
?>
