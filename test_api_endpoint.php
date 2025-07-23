<?php
/**
 * Test API Endpoint
 * Quick test to verify the API endpoint is working
 */

echo "<h2>🔍 Testing API Endpoint...</h2>";

// Test the API endpoint directly
$testData = [
    'fullname' => 'Test User',
    'email' => 'test' . time() . '@example.com', // Unique email
    'family_name' => 'Test Family',
    'phone_no' => '+234-800-000-0000',
    'quarters' => 'Isale Osi',
    'current_address' => 'Test Address, Test City'
];

echo "<h3>Test Data:</h3>";
echo "<pre>" . json_encode($testData, JSON_PRETTY_PRINT) . "</pre>";

// Test the endpoint
$url = "http://" . $_SERVER['HTTP_HOST'] . "/osi_ekiti_node/api/users";
echo "<h3>API URL: {$url}</h3>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen(json_encode($testData))
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "<h3>Response:</h3>";
echo "<p><strong>HTTP Code:</strong> {$httpCode}</p>";

if ($error) {
    echo "<p><strong>cURL Error:</strong> {$error}</p>";
}

if ($response) {
    echo "<p><strong>Response Body:</strong></p>";
    echo "<pre>" . $response . "</pre>";
    
    $decoded = json_decode($response, true);
    if ($decoded) {
        echo "<p><strong>Parsed Response:</strong></p>";
        echo "<pre>" . json_encode($decoded, JSON_PRETTY_PRINT) . "</pre>";
    }
} else {
    echo "<p><strong>No response received</strong></p>";
}

// Test if the API file exists
$apiFile = __DIR__ . '/api/index.php';
echo "<h3>API File Check:</h3>";
if (file_exists($apiFile)) {
    echo "<p>✅ API file exists: {$apiFile}</p>";
} else {
    echo "<p>❌ API file not found: {$apiFile}</p>";
}

// Test .htaccess
$htaccessFile = __DIR__ . '/.htaccess';
echo "<h3>.htaccess Check:</h3>";
if (file_exists($htaccessFile)) {
    echo "<p>✅ .htaccess file exists</p>";
    echo "<p><strong>Content:</strong></p>";
    echo "<pre>" . htmlspecialchars(file_get_contents($htaccessFile)) . "</pre>";
} else {
    echo "<p>❌ .htaccess file not found</p>";
}
?>
