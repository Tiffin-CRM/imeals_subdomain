<?php
// Set response header to JSON
header('Content-Type: application/json');

// Simulate checking if a user exists in the database by email or phone
function checkIfUserExists($email, $phone)
{
    // Database connection details
    $host = 'localhost';
    $dbname = 'u240376517_tiffin_simul';
    $username = 'tiffin_simul';
    $password = '1Alukidukankrenge@';

    try {
        // Create a PDO instance
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the query
        $stmt = $pdo->prepare("SELECT * FROM clients WHERE email = :email OR phone = :phone");
        $stmt->execute(['email' => $email, 'phone' => $phone]);

        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return true if a user is found, false otherwise
        return $result !== false;
    } catch (PDOException $e) {
        // Log the error (in a real-world scenario, use proper error logging)
        error_log("Database Error: " . $e->getMessage());
        return false;
    }
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