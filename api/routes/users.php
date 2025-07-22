<?php
/**
 * Users Routes
 * Handles user CRUD operations (Create, Read, Update, Delete)
 * Your user schema: Fullname, email, Family name, Phone_no, Quaters, current_address
 */

/**
 * Create new user
 * POST /api/users
 */
function createUser() {
    try {
        // Get JSON input (like req.body in Express.js)
        $input = json_decode(file_get_contents('php://input'), true);

        // Validate required fields based on your schema
        $requiredFields = ['fullname', 'email', 'family_name', 'phone_no', 'quarters', 'current_address'];
        foreach ($requiredFields as $field) {
            if (!isset($input[$field]) || empty(trim($input[$field]))) {
                http_response_code(400);
                echo json_encode(['error' => "Missing required field: $field"]);
                return;
            }
        }

        // Create database connection
        $database = new Database();
        $db = $database->getConnection();

        // Include User model
        require_once '../models/User.php';
        $user = new User($db);

        // Validate user data
        $errors = $user->validate($input);
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['error' => 'Validation failed', 'details' => $errors]);
            return;
        }

        // Create user in database
        $userId = $user->create($input);

        if ($userId) {
            // Get the created user
            $createdUser = $user->findById($userId);

            $response = [
                'success' => true,
                'message' => 'User created successfully',
                'data' => $createdUser
            ];

            http_response_code(201);
            echo json_encode($response);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create user']);
        }

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
    }
}

/**
 * Get all users
 * GET /api/users
 */
function getUsers() {
    try {
        // TODO: Fetch from database
        // For now, return sample data with your schema
        $users = [
            [
                'id' => 1,
                'fullname' => 'Adebayo Ogundimu',
                'email' => 'adebayo@example.com',
                'family_name' => 'Ogundimu',
                'phone_no' => '+234-801-234-5678',
                'quarters' => 'Isale Osi',
                'current_address' => 'Lagos, Nigeria',
                'created_at' => '2024-01-15 10:30:00'
            ],
            [
                'id' => 2,
                'fullname' => 'Folake Adeyemi',
                'email' => 'folake@example.com',
                'family_name' => 'Adeyemi',
                'phone_no' => '+234-802-345-6789',
                'quarters' => 'Oke Osi',
                'current_address' => 'Abuja, Nigeria',
                'created_at' => '2024-01-20 14:45:00'
            ]
        ];
        
        $response = [
            'success' => true,
            'data' => $users,
            'count' => count($users)
        ];
        
        echo json_encode($response);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}

/**
 * Search users
 * GET /api/search?q=search_term
 */
function searchUsers() {
    try {
        $searchTerm = $_GET['q'] ?? '';
        
        if (empty($searchTerm)) {
            http_response_code(400);
            echo json_encode(['error' => 'Search term is required']);
            return;
        }
        
        // TODO: Search in database
        // For now, return sample filtered data
        $results = [
            [
                'id' => 1,
                'fullname' => 'Adebayo Ogundimu',
                'email' => 'adebayo@example.com',
                'family_name' => 'Ogundimu',
                'phone_no' => '+234-801-234-5678',
                'quarters' => 'Isale Osi',
                'current_address' => 'Lagos, Nigeria'
            ]
        ];
        
        $response = [
            'success' => true,
            'data' => $results,
            'searchTerm' => $searchTerm,
            'count' => count($results)
        ];
        
        echo json_encode($response);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}

/**
 * Update user
 * PUT /api/users?id=user_id
 */
function updateUser() {
    try {
        $userId = $_GET['id'] ?? '';
        
        if (empty($userId)) {
            http_response_code(400);
            echo json_encode(['error' => 'User ID is required']);
            return;
        }
        
        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);
        
        // TODO: Update in database
        // For now, just return success response
        $response = [
            'success' => true,
            'message' => 'User updated successfully',
            'data' => [
                'id' => $userId,
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        echo json_encode($response);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}

/**
 * Delete user
 * DELETE /api/users?id=user_id
 */
function deleteUser() {
    try {
        $userId = $_GET['id'] ?? '';
        
        if (empty($userId)) {
            http_response_code(400);
            echo json_encode(['error' => 'User ID is required']);
            return;
        }
        
        // TODO: Delete from database
        // For now, just return success response
        $response = [
            'success' => true,
            'message' => 'User deleted successfully',
            'data' => [
                'id' => $userId,
                'deleted_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        echo json_encode($response);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}
?>
