<?php
/**
 * Debug API Endpoint
 * Test the exact endpoint that the form is calling
 */

echo "<h2>🔍 API Endpoint Debug</h2>";

// Simulate the exact request the form makes
$testData = [
    'fullname' => 'Debug Test User',
    'email' => 'debug' . time() . '@example.com',
    'family_name' => 'Debug Family',
    'phone_no' => '+234-800-000-0001',
    'quarters' => 'Isale Osi',
    'current_address' => 'Debug Address, Debug City'
];

echo "<h3>1. Testing Direct API Call</h3>";
echo "<p><strong>Endpoint:</strong> /osi_ekiti_node/api/users</p>";
echo "<p><strong>Method:</strong> POST</p>";
echo "<p><strong>Data:</strong></p>";
echo "<pre>" . json_encode($testData, JSON_PRETTY_PRINT) . "</pre>";

// Test the endpoint using cURL
$url = "http://" . $_SERVER['HTTP_HOST'] . "/osi_ekiti_node/api/users";
echo "<p><strong>Full URL:</strong> {$url}</p>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen(json_encode($testData))
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_VERBOSE, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "<h3>2. Response</h3>";
echo "<p><strong>HTTP Status:</strong> {$httpCode}</p>";

if ($error) {
    echo "<p><strong>cURL Error:</strong> {$error}</p>";
}

if ($response) {
    echo "<p><strong>Response Body:</strong></p>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
    
    $decoded = json_decode($response, true);
    if ($decoded) {
        echo "<p><strong>Parsed JSON:</strong></p>";
        echo "<pre>" . json_encode($decoded, JSON_PRETTY_PRINT) . "</pre>";
    } else {
        echo "<p><strong>JSON Parse Error:</strong> " . json_last_error_msg() . "</p>";
    }
} else {
    echo "<p><strong>No response received</strong></p>";
}

echo "<h3>3. File System Check</h3>";

// Check if files exist
$files = [
    'api/index.php' => 'Main API router',
    'api/routes/users.php' => 'User routes',
    'models/User.php' => 'User model',
    'config/database.php' => 'Database config',
    '.htaccess' => 'Apache config'
];

foreach ($files as $file => $description) {
    $fullPath = __DIR__ . '/' . $file;
    if (file_exists($fullPath)) {
        echo "<p>✅ {$description}: {$file}</p>";
    } else {
        echo "<p>❌ Missing {$description}: {$file}</p>";
    }
}

echo "<h3>4. Server Environment</h3>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Script Path:</strong> " . __DIR__ . "</p>";
echo "<p><strong>Request URI:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";
echo "<p><strong>HTTP Host:</strong> " . $_SERVER['HTTP_HOST'] . "</p>";

echo "<h3>5. Apache Rewrite Test</h3>";
// Test if Apache rewrite is working
$rewriteTestUrl = "http://" . $_SERVER['HTTP_HOST'] . "/osi_ekiti_node/api/test";
echo "<p>Testing rewrite rule with: {$rewriteTestUrl}</p>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $rewriteTestUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);

$rewriteResponse = curl_exec($ch);
$rewriteCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<p><strong>Rewrite Test Status:</strong> {$rewriteCode}</p>";
if ($rewriteResponse) {
    echo "<p><strong>Rewrite Response:</strong></p>";
    echo "<pre>" . htmlspecialchars(substr($rewriteResponse, 0, 500)) . "</pre>";
}
?>
