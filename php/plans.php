<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
// Example: Fetching plans from a database
$meal_plans = [
    ["id" => "1", "type" => "Veg", "name" => "Plan 1", "items" => "4 Roti, Sabji 1, Sabji 2", "price" => 100, "frequency" => "Daily", "time" => "Lunch", "description" => "this is description"],
    ["id" => "2", "type" => "Non Veg", "name" => "Plan 2", "items" => "4 Roti, Chicken Curry", "price" => 200, "frequency" => "Daily", "time" => "Lunch", "description" => "this is description"],
    ["id" => "3", "type" => "Veg", "name" => "Plan 3", "items" => "4 Roti, Sabji 1, Sabji 2", "price" => 300, "frequency" => "Daily", "time" => "Lunch", "description" => "this is description"],
    ["id" => "4", "type" => "Non Veg", "name" => "Plan 4", "items" => "4 Roti, Chicken Curry", "price" => 400, "frequency" => "Daily", "time" => "Lunch", "description" => "this is description"],
    // Add more plans as needed
];

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($meal_plans);
