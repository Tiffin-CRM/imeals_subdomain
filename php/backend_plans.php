<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

function getReadableFrequency($frequency)
{
    $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $availability = explode(',', $frequency);

    $availableDays = [];

    // Collect available days based on the frequency
    foreach ($availability as $index => $value) {
        if ($value == '1') {
            $availableDays[] = $days[$index];
        }
    }

    // Determine readable frequency
    $countAvailable = count($availableDays);

    if ($countAvailable == 7) {
        return "Every Day";
    } elseif ($countAvailable == 5 && $availableDays === ['Mon', 'Tue', 'Wed', 'Thu', 'Fri']) {
        return "Weekdays Only"; // Only Mon-Fri
    } elseif ($countAvailable == 2 && $availableDays === ['Sat', 'Sun']) {
        return "Weekends Only"; // Only Sat-Sun
    } elseif ($countAvailable == 6 && !in_array('Sun', $availableDays)) {
        return "Every Day Except Sunday"; // All days except Sunday
    } elseif ($countAvailable == 6 && !in_array('Sat', $availableDays)) {
        return "Every Day Except Saturday"; // All days except Saturday
    } elseif ($countAvailable > 0) {
        return "On " . implode(', ', $availableDays); // Show available days
    } else {
        return "No Availability"; // No days available
    }
}

function getReadableVegStatus($is_veg)
{
    return $is_veg ? "Vegetarian" : "Non-Vegetarian";
}

// Database credentials
$host = 'localhost';
$dbname = 'u240376517_tiffin_simul';
$username = 'u240376517_tiffin_simul';
$password = '1Alukidukankrenge@';

// Connect to MySQL database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch meal plans from the database
    $stmt = $pdo->query("SELECT id, is_veg, template_name as name, items, price, frequency, time, description FROM order_templates");

    // Fetch all rows as an associative array
    $meal_plans = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convert frequency to readable format
    foreach ($meal_plans as &$meal_plan) {
        $meal_plan['readable_frequency'] = getReadableFrequency($meal_plan['frequency']);
        $meal_plan['type'] = getReadableVegStatus($meal_plan['is_veg']); // Add readable veg status
    }
    // Return data as JSON
    echo json_encode($meal_plans);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>