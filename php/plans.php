<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
// Example: Fetching plans from a database
$meal_plans = [
    ["id" => "plan1", "type" => "veg", "name" => "Plan 1", "description" => "4 Roti, Sabji 1, Sabji 2", "price" => 100, "meal" => "Daily Lunch"],
    ["id" => "plan2", "type" => "nonveg", "name" => "Plan 2", "description" => "4 Roti, Chicken Curry", "price" => 200, "meal" => "Daily Lunch"],
    ["id" => "plan3", "type" => "veg", "name" => "Plan 3", "description" => "4 Roti, Sabji 1, Sabji 2", "price" => 300, "meal" => "Daily Dinner"],
    ["id" => "plan4", "type" => "nonveg", "name" => "Plan 4", "description" => "4 Roti, Chicken Curry", "price" => 400, "meal" => "Daily Breakfast"],
    // Add more plans as needed
];

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($meal_plans);
