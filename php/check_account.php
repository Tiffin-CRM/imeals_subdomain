<?php
// Set response header to JSON
header('Content-Type: application/json');

// Simulate checking if a user exists in the database by email or phone
function checkIfUserExists($email, $phone)
{
    // Simulated existing users (in a real scenario, this would be a database query)
    $existingEmails = ['test@example.com', 'user@domain.com'];
    $existingPhones = ['9068052561', '94'];

    // Check if email or phone exists in the respective arrays
    if (in_array($email, $existingEmails) || in_array($phone, $existingPhones)) {
        return true;
    }
    return false;
}

// Get the raw POST data (the incoming JSON)
$input = file_get_contents('php://input');

// Decode the JSON input
$data = json_decode($input, true);

// Ensure data is provided
if (isset($data['email']) || isset($data['phone'])) {
    $email = isset($data['email']) ? $data['email'] : null;
    $phone = isset($data['phone']) ? $data['phone'] : null;

    // Check if the user exists using email or phone
    if (checkIfUserExists($email, $phone)) {
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
    // Handle missing email or phone in the request
    $response = [
        'error' => true,
        'message' => 'No email or phone provided.'
    ];
}

// Send the JSON response
echo json_encode($response);
?>