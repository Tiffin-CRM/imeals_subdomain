<?php
// Enable error reporting for development (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
// Set the content type to JSON
header('Content-Type: application/json');


// Function to send a POST request to the webhook
function sendToWebhook($data)
{
    $url = "https://webhook.site/47c2735c-19fc-4884-ad61-1cca4febb0b4";

    // Use curl to send data
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // return ['response' => $response, 'httpCode' => $httpCode];
    return ['response' => 'success', 'httpCode' => '200'];

}

// Validate and sanitize input
function validateInput($data)
{
    $errors = [];

    // Full Name Validation
    if (empty($data['name']) || !preg_match("/^[a-zA-Z\s]+$/", $data['name'])) {
        $errors['name'] = "Invalid full name.";
    }

    // Phone Number Validation
    if (empty($data['phone']) || !preg_match("/^\d{10}$/", $data['phone'])) {
        $errors['phone'] = "Invalid phone number. It must be 10 digits.";
    }

    // Zone Validation
    if (empty($data['zone'])) {
        $errors['zone'] = "Zone/Area is required.";
    }

    // Address Validation
    if (empty($data['address'])) {
        $errors['address'] = "Address is required.";
    }

    // Location Validation
    if (empty($data['location'])) {
        $errors['location'] = "Delivery location is required.";
    }

    // Dietary Preference Validation
    if (empty($data['diet_pref'])) {
        $errors['diet_pref'] = "Dietary preference is required.";
    }

    return $errors;
}

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);

// Debug: Check incoming data
if ($data === null) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input.']);
    http_response_code(400); // Bad Request
    exit;
}

// Validate input
$errors = validateInput($data);

// Debug: Check for validation errors
if (!empty($errors)) {
    echo json_encode(['status' => 'error', 'errors' => $errors]);
    http_response_code(400); // Bad Request
    exit;
}

// Send data to webhook
$result = sendToWebhook($data);

// Check response from webhook
if ($result['httpCode'] == 200) {
    echo json_encode(['status' => 'success', 'message' => 'Data submitted successfully.', 'response' => $result['response']]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to send data to the webhook.', 'response' => $result['response']]);
    http_response_code(500); // Internal Server Error
}