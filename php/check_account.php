<?php
// Set response header to JSON
header('Content-Type: application/json');

// Function to simulate checking if a user exists
function checkIfUserExists($phone)
{
    // This would typically involve checking the database.
    // For this example, let's say these phones are existing.
    $existingUsers = ['9068062563', '656'];

    if (in_array($phone, $existingUsers)) {
        return true;
    }
    return false;
}

// Get the raw POST data (the incoming JSON)
$input = file_get_contents('php://input');

// Decode the JSON input
$data = json_decode($input, true);

// Ensure data is provided
if (isset($data['phone'])) {
    $phone = $data['phone'];

    // Check if the user exists
    if (checkIfUserExists($phone)) {
        $response = [
            'usertype' => 'existing',
            'message' => 'User is already registered.'
        ];
    } else {
        $response = [
            'usertype' => 'new',
            'message' => 'User is new and not registered.'
        ];
    }
} else {
    // Handle missing phone in the request
    $response = [
        'error' => true,
        'message' => 'No phone provided.'
    ];
}

// Send the JSON response
echo json_encode($response);
?>