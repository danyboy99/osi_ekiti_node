<?php
/**
 * API Test Script
 * Test all your API endpoints to make sure they're working
 */

echo "<h2>🚀 Testing API Endpoints...</h2>";

$baseUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/api";

// Function to make HTTP requests
function makeRequest($url, $method = 'GET', $data = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    
    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ['code' => $httpCode, 'body' => $response];
}

echo "<h3>🌐 Base API URL: {$baseUrl}</h3>";

// Test 1: GET /api/users (Get all users)
echo "<h3>1. Testing GET /api/users</h3>";
$response = makeRequest($baseUrl . "/users");
echo "Status Code: {$response['code']}<br>";
if ($response['code'] == 200) {
    echo "✅ Success!<br>";
    $data = json_decode($response['body'], true);
    echo "Response: <pre>" . json_encode($data, JSON_PRETTY_PRINT) . "</pre>";
} else {
    echo "❌ Failed<br>";
    echo "Response: " . $response['body'] . "<br>";
}

// Test 2: POST /api/users (Create user)
echo "<h3>2. Testing POST /api/users</h3>";
$testUser = [
    'fullname' => 'Test User',
    'email' => 'test@example.com',
    'family_name' => 'TestFamily',
    'phone_no' => '+234-900-000-0000',
    'quarters' => 'Test Quarter',
    'current_address' => 'Test Address, Test City'
];

$response = makeRequest($baseUrl . "/users", 'POST', $testUser);
echo "Status Code: {$response['code']}<br>";
if ($response['code'] == 201) {
    echo "✅ User created successfully!<br>";
    $data = json_decode($response['body'], true);
    echo "Response: <pre>" . json_encode($data, JSON_PRETTY_PRINT) . "</pre>";
    $createdUserId = $data['data']['id'] ?? null;
} else {
    echo "❌ Failed to create user<br>";
    echo "Response: " . $response['body'] . "<br>";
    $createdUserId = null;
}

// Test 3: GET /api/search (Search users)
echo "<h3>3. Testing GET /api/search</h3>";
$response = makeRequest($baseUrl . "/search?q=Test");
echo "Status Code: {$response['code']}<br>";
if ($response['code'] == 200) {
    echo "✅ Search successful!<br>";
    $data = json_decode($response['body'], true);
    echo "Response: <pre>" . json_encode($data, JSON_PRETTY_PRINT) . "</pre>";
} else {
    echo "❌ Search failed<br>";
    echo "Response: " . $response['body'] . "<br>";
}

// Test 4: PUT /api/users (Update user) - only if we created a user
if ($createdUserId) {
    echo "<h3>4. Testing PUT /api/users</h3>";
    $updateData = [
        'fullname' => 'Updated Test User',
        'email' => 'updated@example.com',
        'family_name' => 'UpdatedFamily',
        'phone_no' => '+234-900-111-1111',
        'quarters' => 'Updated Quarter',
        'current_address' => 'Updated Address, Updated City'
    ];
    
    $response = makeRequest($baseUrl . "/users?id=" . $createdUserId, 'PUT', $updateData);
    echo "Status Code: {$response['code']}<br>";
    if ($response['code'] == 200) {
        echo "✅ User updated successfully!<br>";
        $data = json_decode($response['body'], true);
        echo "Response: <pre>" . json_encode($data, JSON_PRETTY_PRINT) . "</pre>";
    } else {
        echo "❌ Failed to update user<br>";
        echo "Response: " . $response['body'] . "<br>";
    }
}

// Test 5: DELETE /api/users (Delete user) - only if we created a user
if ($createdUserId) {
    echo "<h3>5. Testing DELETE /api/users</h3>";
    $response = makeRequest($baseUrl . "/users?id=" . $createdUserId, 'DELETE');
    echo "Status Code: {$response['code']}<br>";
    if ($response['code'] == 200) {
        echo "✅ User deleted successfully!<br>";
        $data = json_decode($response['body'], true);
        echo "Response: <pre>" . json_encode($data, JSON_PRETTY_PRINT) . "</pre>";
    } else {
        echo "❌ Failed to delete user<br>";
        echo "Response: " . $response['body'] . "<br>";
    }
}

echo "<h3>✨ API Testing Complete!</h3>";
echo "<p>Check the results above to see if your API is working correctly.</p>";
?>
