<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Origin: http://127.0.0.1:3000");

header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Database connection parameters
$host = 'localhost'; // Change this if your database is hosted elsewhere
$dbname = 'u240376517_tiffin_simul';
$username = 'u240376517_tiffin_simul';
$password = '1Alukidukankrenge@';

try {
    // Create a PDO instance (connect to the database)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the raw POST data
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Assuming the incoming data contains these fields
    $mealPlans = $data['mealPlans']; // Array of selected meal plans
    $clientId = 1; // This should come from your session or authentication mechanism
    $templateId = NULL; // You may want to set this based on your logic
    $note = NULL; // Optional note field, can be set if needed

    foreach ($mealPlans as $planId) {
        // Prepare the SQL INSERT statement
        $stmt = $pdo->prepare("
            INSERT INTO orders (start_from, expiry_date, client_id, template_id, labels, time, is_veg, frequency, price, items, is_active, note, deleted, created_on, type)
            VALUES (:start_from, :expiry_date, :client_id, :template_id, :labels, :time, :is_veg, :frequency, :price, :items, :is_active, :note, :deleted, NOW(), :type)
        ");

        // Replace with your actual logic to fetch meal plan details, here we assume the values are static
        $startFrom = date('Y-m-d H:i:s'); // Set start date to now or as needed
        $expiryDate = date('Y-m-d H:i:s', strtotime('+1 week')); // Set to one week from now or customize
        $labels = "Regular"; // You can change this based on your logic
        $time = "Lunch"; // Example: this should match the meal time
        $isVeg = 1; // Example: Set based on your meal plan
        $frequency = "1,1,1,1,1,0,0"; // Example: Set based on your meal plan
        $price = 40; // Example: Set based on your meal plan
        $items = "Chawal, Dal, Sabji 1, Sabji 2"; // Example: Set based on your meal plan
        $isActive = 1; // Default active status
        $deleted = 0; // Default deleted status
        $type = "repeat"; // Change based on whether it's a repeat or one-time order

        // Execute the statement with the bound parameters
        $stmt->execute([
            ':start_from' => $startFrom,
            ':expiry_date' => $expiryDate,
            ':client_id' => $clientId,
            ':template_id' => $templateId,
            ':labels' => $labels,
            ':time' => $time,
            ':is_veg' => $isVeg,
            ':frequency' => $frequency,
            ':price' => $price,
            ':items' => $items,
            ':is_active' => $isActive,
            ':note' => $note,
            ':deleted' => $deleted,
            ':type' => $type
        ]);
    }

    // Return a success response
    echo json_encode(['status' => 'success', 'message' => 'Orders inserted successfully']);
} catch (PDOException $e) {
    // Handle errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>