<?php
header("Access-Control-Allow-Origin: *");
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

    // Check if mealPlans is set and is an array
    if (!isset($data['mealPlans']) || !is_array($data['mealPlans']) || empty($data['mealPlans'])) {
        echo json_encode(['error' => 'No meal plans selected']);
        exit; // Stop execution
    }

    $mealPlans = $data['mealPlans']; // Array of selected meal plans
    $clientId = 1; // This should come from your session or authentication mechanism
    $templateId = NULL; // You may want to set this based on your logic
    $note = NULL; // Optional note field, can be set if needed

    $successfulInserts = 0; // Count successful inserts

    foreach ($mealPlans as $planId) {
        // Fetch plan details from the database based on planId
        $stmt = $pdo->prepare("SELECT * FROM meal_plans WHERE id = :id");
        $stmt->execute([':id' => $planId]);
        $plan = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the plan exists
        if ($plan) {
            // Prepare the SQL INSERT statement
            $insertStmt = $pdo->prepare("
                INSERT INTO orders (start_from, expiry_date, client_id, template_id, labels, time, is_veg, frequency, price, items, is_active, note, deleted, created_on, type)
                VALUES (:start_from, :expiry_date, :client_id, :template_id, :labels, :time, :is_veg, :frequency, :price, :items, :is_active, :note, :deleted, NOW(), :type)
            ");

            // Example values based on fetched plan
            $startFrom = date('Y-m-d H:i:s'); // Set start date to now or as needed
            $expiryDate = date('Y-m-d H:i:s', strtotime('+1 week')); // Set to one week from now or customize
            $labels = "Regular"; // You can change this based on your logic
            $time = $plan['time']; // Assuming time is part of the plan
            $isVeg = $plan['type']; // Assuming type is 1 for veg, 0 for non-veg
            $frequency = $plan['frequency']; // Assuming frequency is part of the plan
            $price = $plan['price']; // Assuming price is part of the plan
            $items = $plan['items']; // Assuming items are part of the plan
            $isActive = 1; // Default active status
            $deleted = 0; // Default deleted status
            $type = "repeat"; // Change based on whether it's a repeat or one-time order

            // Execute the insert statement
            $inserted = $insertStmt->execute([
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

            // Check if the insert was successful
            if ($inserted) {
                $successfulInserts++;
            }
        } else {
            echo json_encode(['error' => "Meal plan with ID $planId does not exist."]);
            exit; // Stop execution
        }
    }

    // Return a success response if any inserts were successful
    if ($successfulInserts > 0) {
        echo json_encode(['status' => 'success', 'message' => "$successfulInserts orders inserted successfully."]);
    } else {
        echo json_encode(['error' => 'No orders were inserted.']);
    }
} catch (PDOException $e) {
    // Handle errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>