<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

function getReadableFrequency($frequency)
{
    $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $frequencyArr = explode(',', $frequency);
    $activeDays = [];

    foreach ($frequencyArr as $index => $value) {
        if ($value == '1') {
            $activeDays[] = $days[$index];
        }
    }

    if (count($activeDays) == 7) {
        return "Every Day";
    } elseif (count($activeDays) == 6 && !in_array('Sun', $activeDays)) {
        return "Every Day Except Sunday";
    } elseif (count($activeDays) == 1 && in_array('Sun', $activeDays)) {
        return "On Sunday Only";
    } elseif (count($activeDays) == 0) {
        return "No Days Selected";
    } else {
        return "On " . implode(', ', $activeDays);
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