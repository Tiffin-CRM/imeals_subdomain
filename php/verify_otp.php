<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
// Set the content type to JSON
header('Content-Type: application/json');

session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $enteredOTP = $data->otp;

    // Retrieve the OTP from the user's session
    $storedOTP = isset($_SESSION['otp']) ? $_SESSION['otp'] : null;

    if ($storedOTP && $enteredOTP === $storedOTP) {

        if (isset($_SESSION['phone'])) {
            // Get the phone number from the session
            $phone = $_SESSION['phone'];
            // Multiply the phone number by 4578348
            $cookie_value = $phone * 4578348;
            // Set the cookie with the calculated value
            setcookie("token", $cookie_value, time() + (86400 * 900), "/"); // 86400 = 1 day
        }
        echo json_encode(['message' => 'OTP Verified successfully!']);

    } else {
        echo json_encode(['message' => 'Incorrect OTP. Please try again.']);
    }
}
?>