<?php
// Example: Fetching plans from a database
$meal_plans = [
    ["id" => "plan3", "type" => "veg", "name" => "Plan 3", "description" => "4 Roti, Sabji 1, Sabji 2", "price" => 200, "meal" => "Daily Lunch"],
    ["id" => "plan4", "type" => "nonveg", "name" => "Plan 4", "description" => "4 Roti, Chicken Curry", "price" => 250, "meal" => "Daily Lunch"],
    // Add more plans as needed
];

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($meal_plans);
