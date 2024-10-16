<?php
// ... existing code ...

try {
    // ... existing code ...

    $mealPlans = $data['selectedPlans'] ?? null;
    $clientId = $data['client_id'] ?? '1'; // Default to 1 if not provided
    $vendorId = $data['vendor_id'] ?? '1';
    // Check if mealPlans, client_id, and vendor_id are set
    if (!isset($mealPlans) || !isset($clientId) || !isset($vendorId)) {
        echo json_encode(['error' => 'Required parameters are missing']);
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

    // Loop through each selected meal plan
    foreach ($mealPlans as $templateId) {
        // Fetch meal plan details based on template_id and vendor_id
        $stmt = $pdo->prepare("
            SELECT * FROM order_templates 
            WHERE id = :template_id AND vendor_id = :vendor_id
        ");
        $stmt->execute([':template_id' => $templateId, ':vendor_id' => $vendorId]);
        $mealPlan = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if meal plan exists
        if (!$mealPlan) {
            echo json_encode(['error' => "Meal plan not found for template ID: $templateId"]);
            continue; // Skip to the next meal plan
        }

        // Prepare values from the meal plan
        $time = $mealPlan['time'] ?? null;
        $isVeg = $mealPlan['is_veg'] ?? null;
        $frequency = $mealPlan['frequency'] ?? null;
        $price = $mealPlan['price'] ?? null;
        $items = $mealPlan['items'] ?? null;
        $isActive = 1; // Set is_active to 1
        $approved = 1; // Set approved to 1
        $type = $mealPlan['type'] ?? null;

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

        if (!$inserted) {
            echo json_encode(['error' => "Failed to insert order for template ID: $templateId"]);
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'Orders inserted successfully']);

} catch (PDOException $e) {
    // Handle errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>