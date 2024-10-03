<?php
// Set the content type to JSON
header('Content-Type: application/json');

// Get the raw POST data
$jsonData = file_get_contents('php://input');

// Decode the JSON data into a PHP array
$data = json_decode($jsonData, true);

// Check if mealPlans is set and is an array
if (isset($data['mealPlans']) && is_array($data['mealPlans'])) {
    $receivedPlans = $data['mealPlans'];

    // Prepare data to send to the webhook
    $webhookData = json_encode(['mealPlans' => $receivedPlans]);

    // Send the data to the webhook
    $webhookUrl = 'https://webhook.site/47c2735c-19fc-4884-ad61-1cca4febb0b4';
    // https://webhook.site/#!/view/47c2735c-19fc-4884-ad61-1cca4febb0b4/c5466a52-ca6b-45bf-9d93-9905dab4f7e0/1
    // Using cURL to send the webhook data
    $ch = curl_init($webhookUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $webhookData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($webhookData)
    ]);

    // Execute the request
    $response = curl_exec($ch);

    // Check for errors
    if ($response === false) {
        // Log the error or handle it as needed
        error_log('Webhook error: ' . curl_error($ch));
    }

    // Close the cURL session
    curl_close($ch);

    // Here, you would typically save the received meal plans to a database or perform other operations
    // Example: 
    // $db->insertMealPlans($receivedPlans); // Replace this with your actual database insertion logic

    // Respond with a success message and the received data
    echo json_encode([
        'status' => 'success',
        'message' => 'Meal plans added successfully and sent to the webhook.',
        'data' => $receivedPlans
    ]);
} else {
    // If the data is not set or is invalid, return an error response
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid input. Meal plans not received.'
    ]);
}
?>