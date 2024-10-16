<?php
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

    // Check if template_id, client_id, and vendor_id are set
    if (!isset($data['template_id']) || !isset($data['client_id']) || !isset($data['vendor_id'])) {
        echo json_encode(['error' => 'Required parameters are missing']);
        exit; // Stop execution
    }

    $templateId = $data['template_id'];
    $clientId = $data['client_id'];
    $vendorId = $data['vendor_id'];

    // Fetch meal plan details based on template_id and vendor_id
    $stmt = $pdo->prepare("
        SELECT * FROM order_templates 
        WHERE template_id = :template_id AND vendor_id = :vendor_id
    ");
    $stmt->execute([':template_id' => $templateId, ':vendor_id' => $vendorId]);
    $mealPlan = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if meal plan exists
    if (!$mealPlan) {
        echo json_encode(['error' => 'Meal plan not found for the given template and vendor']);
        exit; // Stop execution
    }

    // Prepare the SQL INSERT statement for the orders table
    $insertStmt = $pdo->prepare("
        INSERT INTO orders (start_from, expiry_date, client_id, template_id, labels, time, is_veg, frequency, price, items, is_active, note, deleted, created_on, type)
        VALUES (:start_from, :expiry_date, :client_id, :template_id, :labels, :time, :is_veg, :frequency, :price, :items, :is_active, :note, :deleted, NOW(), :type)
    ");

    // Example values based on fetched meal plan
    $startFrom = date('Y-m-d H:i:s'); // Set start date to now or as needed
    $expiryDate = date('Y-m-d H:i:s', strtotime('+1 week')); // Set to one week from now or customize
    $labels = $mealPlan['labels'] ?? "Regular"; // Get labels from meal plan or use a default
    $time = $mealPlan['time']; // Assuming time is part of the meal plan
    $isVeg = $mealPlan['is_veg']; // Assuming is_veg is part of the meal plan
    $frequency = $mealPlan['frequency']; // Assuming frequency is part of the meal plan
    $price = $mealPlan['price']; // Assuming price is part of the meal plan
    $items = $mealPlan['items']; // Assuming items are part of the meal plan
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
        ':note' => null, // Set if needed
        ':deleted' => $deleted,
        ':type' => $type
    ]);

    // Check if the insert was successful
    if ($inserted) {
        echo json_encode(['status' => 'success', 'message' => 'Order inserted successfully']);
    } else {
        echo json_encode(['error' => 'Failed to insert the order']);
    }

} catch (PDOException $e) {
    // Handle errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>