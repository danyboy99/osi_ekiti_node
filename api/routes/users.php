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
        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);

        // Check for JSON parsing errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode([
                'error' => 'Invalid JSON format',
                'details' => ['Please ensure you are sending valid JSON data']
            ]);
            return;
        }

        // Check if input is empty
        if (empty($input)) {
            http_response_code(400);
            echo json_encode([
                'error' => 'No data provided',
                'details' => ['Please provide user registration data']
            ]);
            return;
        }

        // Validate required fields based on your schema
        $requiredFields = ['fullname', 'email', 'family_name', 'phone_no', 'quarters', 'current_address'];
        $missingFields = [];

        foreach ($requiredFields as $field) {
            if (!isset($input[$field]) || empty(trim($input[$field]))) {
                $missingFields[] = ucfirst(str_replace('_', ' ', $field)) . ' is required';
            }
        }

        if (!empty($missingFields)) {
            http_response_code(400);
            echo json_encode([
                'error' => 'Missing required fields',
                'details' => $missingFields
            ]);
            return;
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
                'message' => 'Registration successful! Welcome to the Osi-Ekiti community!',
                'data' => $createdUser
            ];

            http_response_code(201);
            echo json_encode($response);
        } else {
            http_response_code(500);
            echo json_encode([
                'error' => 'Failed to create user account',
                'details' => ['There was a problem saving your information. Please try again.']
            ]);
        }

    } catch (PDOException $e) {
        // Database specific errors
        http_response_code(500);
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            echo json_encode([
                'error' => 'Email already exists',
                'details' => ['This email address is already registered. Please use a different email.']
            ]);
        } else {
            echo json_encode([
                'error' => 'Database error',
                'details' => ['Unable to save your information. Please try again later.']
            ]);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Server error',
            'details' => ['An unexpected error occurred. Please try again later.']
        ]);
    }
}

/**
 * Get all users
 * GET /api/users
 */
function getUsers() {
    try {
        // Create database connection
        $database = new Database();
        $db = $database->getConnection();

        // Include User model
        require_once '../models/User.php';
        $user = new User($db);

        // Fetch all users from database
        $users = $user->getAll();

        $response = [
            'success' => true,
            'data' => $users,
            'count' => count($users)
        ];

        echo json_encode($response);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
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

        // Create database connection
        $database = new Database();
        $db = $database->getConnection();

        // Include User model
        require_once '../models/User.php';
        $user = new User($db);

        // Search in database
        $results = $user->search($searchTerm);

        $response = [
            'success' => true,
            'data' => $results,
            'searchTerm' => $searchTerm,
            'count' => count($results)
        ];

        echo json_encode($response);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
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

        // Create database connection
        $database = new Database();
        $db = $database->getConnection();

        // Include User model
        require_once '../models/User.php';
        $user = new User($db);

        // Validate user data
        $errors = $user->validate($input, true, $userId);
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['error' => 'Validation failed', 'details' => $errors]);
            return;
        }

        // Update user in database
        $success = $user->update($userId, $input);

        if ($success) {
            // Get the updated user
            $updatedUser = $user->findById($userId);

            $response = [
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $updatedUser
            ];

            echo json_encode($response);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update user']);
        }

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
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

        // Create database connection
        $database = new Database();
        $db = $database->getConnection();

        // Include User model
        require_once '../models/User.php';
        $user = new User($db);

        // Check if user exists
        $existingUser = $user->findById($userId);
        if (!$existingUser) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            return;
        }

        // Delete user from database
        $success = $user->delete($userId);

        if ($success) {
            $response = [
                'success' => true,
                'message' => 'User deleted successfully',
                'data' => [
                    'id' => $userId,
                    'deleted_at' => date('Y-m-d H:i:s')
                ]
            ];

            echo json_encode($response);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete user']);
        }

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
    }
}
?>
