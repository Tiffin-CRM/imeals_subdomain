<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

function getReadableFrequency($frequency)
{
    $days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    $availability = explode(',', $frequency);

    $availableDays = [];
    $weekdays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
    $weekendDays = ['Sat', 'Sun'];

    foreach ($availability as $index => $value) {
        if ($value == '1') {
            $availableDays[] = $days[$index];
        }
    }

    // Determine readable frequency
    if (count($availableDays) == 7) {
        return "Every Day";
    } elseif (count($availableDays) == 5 && count(array_intersect($availableDays, $weekdays)) == 5) {
        return "Weekdays Only"; // Only Mon-Fri
    } elseif (count($availableDays) == 2 && count(array_intersect($availableDays, $weekendDays)) == 2) {
        return "Weekends Only"; // Only Sat-Sun
    } elseif (count($availableDays) == 6 && !in_array('Sun', $availableDays)) {
        return "Every Day Except Sunday"; // All days except Sunday
    } elseif (count($availableDays) == 6 && !in_array('Sat', $availableDays)) {
        return "Every Day Except Saturday"; // All days except Saturday
    } elseif (count($availableDays) > 0) {
        return "On " . implode(', ', $availableDays);
    } else {
        return "No Availability"; // No days available
    }
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
    $stmt = $pdo->query("SELECT id, is_veg as type, template_name as name, items, price, frequency, time, description FROM order_templates");

    // Fetch all rows as an associative array
    $meal_plans = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convert frequency to readable format
    foreach ($meal_plans as &$plan) {
        $plan['readable_frequency'] = getReadableFrequency($plan['frequency']);
    }
    // Return data as JSON
    echo json_encode($meal_plans);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>