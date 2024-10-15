<?php
// Set response header to JSON
header('Content-Type: application/json');

// Simulate checking if a user exists in the database by email or phone
function checkIfUserExists($email, $phone)
{
    // Database connection details
    $host = 'localhost';
    $dbname = 'u240376517_tiffin_simul';
    $username = 'u240376517_tiffin_simul';
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
    $email = isset($data['email']) ? filter_var($data['email'], FILTER_SANITIZE_EMAIL) : null;
    $phone = isset($data['phone']) ? filter_var($data['phone'], FILTER_SANITIZE_STRING) : null;

    // Check if the user exists using email or phone
    $userExists = checkIfUserExists($email, $phone);

    if ($userExists === null) {
        http_response_code(500);
        $response = [
            'error' => true,
            'message' => 'An error occurred while checking user status.'
        ];
    } elseif ($userExists) {
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
    http_response_code(400);
    $response = [
        'error' => true,
        'message' => 'No email or phone provided.'
    ];
}


// Send the JSON response
echo json_encode($response);
?>