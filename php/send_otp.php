<?php
session_start(); // Start the session

// Function to check if the user has exceeded the request limit
function hasExceededRequestLimit($limit, $window)
{
    // Get the current timestamp
    $currentTime = time();

    // Initialize session variables if not set
    if (!isset($_SESSION['request_count'])) {
        $_SESSION['request_count'] = 0;
        $_SESSION['request_start_time'] = $currentTime;
    }

    // Increment the request count if within the time window
    if ($_SESSION['request_start_time'] + $window >= $currentTime) {
        $_SESSION['request_count']++;
    } else {
        // Reset request count and start time if the time window has passed
        $_SESSION['request_count'] = 1;
        $_SESSION['request_start_time'] = $currentTime;
    }

    // Check if the request count has exceeded the limit
    return $_SESSION['request_count'] > $limit;
}

// Check if the user has exceeded the request limit (e.g., 5 requests per minute)
if (hasExceededRequestLimit(5, 60)) {
    // If the limit is exceeded, return an error response
    http_response_code(429); // 429 Too Many Requests
    echo json_encode(['error' => 'Rate limit exceeded. Please try again later.']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $phoneNumber = $data->phoneNumber;

    // Generate a random 4-digit OTP
    $otp = strval(rand(1000, 9999));

    // Store the OTP and data in the user's session
    $_SESSION['otp'] = $otp;
    $_SESSION['phone'] = $phoneNumber;


    // Prepare the payload to send to the webhook
    $payload = json_encode(array("phoneNumber" => $phoneNumber, "otp" => $otp));

    // Debugging: Output the payload
    $debug['payload'] = $payload;

    // Set up cURL to make a POST request to the webhook URL
    $ch = curl_init("https://webhook.site/47c2735c-19fc-4884-ad61-1cca4febb0b4");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL request
    $response = curl_exec($ch);

    // Debugging: Output the response
    // $debug['webhook_response'] = $response;

    if (curl_errno($ch)) {
        $debug['error'] = 'Error occurred while sending OTP.';
    } else {
        // Integration with SMS gateway Fast2Sms API to send real SMS message
        $smsPayload = http_build_query(
            array(
                'variables_values' => $otp,
                'route' => 'otp',
                'numbers' => $phoneNumber
            )
        );

        // Debugging: Output the SMS payload
        // $debug['sms_payload'] = $smsPayload;

        $ch = curl_init("https://webhook.site/3844eaa9-7726-4f29-91f3-c330e985b10b");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $smsPayload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'authorization: z7UZxnZfklfivP7B56x3v5tZaI6khsPgQHrD1n2KJH2O7UmKKt3Rs7piyGLS',
            'Content-Type: application/x-www-form-urlencoded'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the cURL request
        $smsResponse = curl_exec($ch);

        // Debugging: Output the SMS response
        // $debug['sms_response'] = $smsResponse;

        if (curl_errno($ch)) {
            $debug['error'] = 'Error occurred while sending SMS.';
        } else {
            // Check the HTTP status code of the response
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($statusCode == 200) {
                $debug['success'] = true;
            } else {
                $debug['error'] = 'Failed to send SMS.';
            }
        }
    }

    // Close cURL session
    curl_close($ch);

    // Return debugging information in JSON format
    header('Content-Type: application/json');
    echo json_encode($debug);

}
?>