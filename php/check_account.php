<?php
// Set response header to JSON
header('Content-Type: application/json');

// Function to simulate checking if a user exists
function checkIfUserExists($email)
{
    // This would typically involve checking the database.
    // For this example, let's say these emails are existing.
    $existingUsers = ['test@example.com', 'user@domain.com'];

    if (in_array($email, $existingUsers)) {
        return true;
    }
    return false;
}

// Get the raw POST data (the incoming JSON)
$input = file_get_contents('php://input');

// Decode the JSON input
$data = json_decode($input, true);

// Ensure data is provided
if (isset($data['email'])) {
    $email = $data['email'];

    // Check if the user exists
    if (checkIfUserExists($email)) {
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
    // Handle missing email in the request
    $response = [
        'error' => true,
        'message' => 'No email provided.'
    ];
}

// Send the JSON response
echo json_encode($response);
?>