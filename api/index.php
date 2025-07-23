<?php
/**
 * Main API Router
 * This is like your main app.js file in Node.js
 */

// Enable CORS (Cross-Origin Resource Sharing) - like cors middleware in Express
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// Handle preflight OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Include our database configuration
require_once '../config/database.php';

// Include our user routes
require_once 'routes/users.php';

/**
 * Simple Router Class
 * This handles routing like Express.js router
 */
class Router {
    private $routes = [];

    public function get($path, $handler) {
        $this->routes['GET'][$path] = $handler;
    }

    public function post($path, $handler) {
        $this->routes['POST'][$path] = $handler;
    }

    public function put($path, $handler) {
        $this->routes['PUT'][$path] = $handler;
    }

    public function delete($path, $handler) {
        $this->routes['DELETE'][$path] = $handler;
    }

    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Debug logging
        error_log("API Request - Method: $method, Full Path: $path");

        // Remove the project path and /api from the path
        $path = str_replace('/osi_ekiti_node/api', '', $path);
        $path = str_replace('/api', '', $path);

        // If path is empty, set it to root
        if (empty($path)) {
            $path = '/';
        }

        error_log("API Request - Processed Path: $path");

        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            call_user_func($handler);
        } else {
            http_response_code(404);
            echo json_encode([
                'error' => 'Route not found',
                'debug' => [
                    'method' => $method,
                    'requested_path' => $path,
                    'available_routes' => array_keys($this->routes[$method] ?? [])
                ]
            ]);
        }
    }
}

// Create router instance
$router = new Router();

// Define our 4 CRUD routes for users
$router->post('/users', 'createUser');        // Create user
$router->get('/users', 'getUsers');           // Get all users
$router->get('/search', 'searchUsers');       // Search users
$router->put('/users', 'updateUser');         // Update user
$router->delete('/users', 'deleteUser');      // Delete user

// Add a test route for debugging
$router->get('/test', function() {
    echo json_encode(['message' => 'API is working!', 'timestamp' => date('Y-m-d H:i:s')]);
});

// Handle the incoming request
$router->handleRequest();
?>
