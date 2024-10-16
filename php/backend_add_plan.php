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

    $mealPlans = $data['selectedPlans'] ?? [null];
    $clientId = $data['client_id'] ?? '1';
    $vendorId = $data['vendor_id'] ?? '1';
    // Check if template_id, client_id, and vendor_id are set
    if (!isset($mealPlans) || !isset($clientId) || !isset($vendorId)) {
        echo json_encode(['error' => 'Required parameters are missing']);
        exit; // Stop execution
    }

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
     INSERT INTO orders (
         client_id, 
         template_id, 
         time, 
         is_veg, 
         frequency, 
         price, 
         items, 
         is_active, 
         approved, 
         type, 
         created_on
     ) VALUES (
         :client_id, 
         :template_id, 
         :time, 
         :is_veg, 
         :frequency, 
         :price, 
         :items, 
         :is_active, 
         :approved, 
         :type, 
         NOW()
     )
 ");

    // Prepare values from the meal plan
    $time = $mealPlan['time']; // Assuming time is part of the meal plan
    $isVeg = $mealPlan['is_veg']; // Assuming is_veg is part of the meal plan
    $frequency = $mealPlan['frequency']; // Assuming frequency is part of the meal plan
    $price = $mealPlan['price']; // Assuming price is part of the meal plan
    $items = $mealPlan['items']; // Assuming items are part of the meal plan
    $isActive = 1; // Set is_active to 1
    $approved = 1; // Set approved to 1
    $type = $mealPlan['type']; // Get the type from meal plan

    // Execute the insert statement
    $inserted = $insertStmt->execute([
        ':client_id' => $clientId,
        ':template_id' => $templateId,
        ':time' => $time,
        ':is_veg' => $isVeg,
        ':frequency' => $frequency,
        ':price' => $price,
        ':items' => $items,
        ':is_active' => $isActive,
        ':approved' => $approved,
        ':type' => $type,
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