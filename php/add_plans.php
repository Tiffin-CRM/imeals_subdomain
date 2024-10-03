<?php
// Set the content type to JSON
header('Content-Type: application/json');

// Get the raw POST data
$jsonData = file_get_contents('php://input');

// Decode the JSON data into a PHP array
$data = json_decode($jsonData, true);

// Check if mealPlans is set and is an array
if (isset($data['mealPlans']) && is_array($data['mealPlans'])) {
    // For demonstration, we'll just return the received meal plans
    $receivedPlans = $data['mealPlans'];

    // Here, you would typically save the received meal plans to a database or perform other operations
    // For example: 
    // $db->insertMealPlans($receivedPlans); // Replace this with your actual database insertion logic

    // Respond with a success message and the received data
    echo json_encode([
        'status' => 'success',
        'message' => 'Meal plans added successfully.',
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