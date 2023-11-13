<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mobileNumber = $_POST['mobileNumber'];

    // Fetch a PIN from the 'pins' table
    $pinQuery = "SELECT pin_value FROM pins LIMIT 1";
    $pinResult = $connection->query($pinQuery);

    if ($pinResult && $pinResult->num_rows > 0) {
        $pinRow = $pinResult->fetch_assoc();
        $pinValue = $pinRow['pin_value'];

        // Send the PIN to the user's mobile number
        $message = "Your authentication PIN is: $pinValue";
        sendPinToMobile($mobileNumber, $message);

        echo "PIN sent successfully.";
    } else {
        echo "Error fetching PIN from the database.";
    }
} else {
    echo "Invalid request method.";
}

function sendPinToMobile($mobileNumber, $message) {
    // Your SMS sending code here
    // Use the provided $mobileNumber and $message to send the PIN to the user
    // Example: Send an SMS using your SMS API
    // ...

    $payload = [
        "username" => "eArthur",
        "password" => "1c96sUDrmPzhZvKM@",
        "senderid" => "ARTHUR",
        "destinations" => [
            [
                "destination" => $mobileNumber,
                "msgid" => 101
            ]
        ],
        "message" => $message,
        "service" => "SMS",
        "subject" => "Hello World",
        "smstype" => "text"
    ];

    $url = "https://frog.wigal.com.gh/api/v2/sendmsg";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Error: " . curl_error($ch);
    } else {
        // Decode the JSON response and display it
        $responseArray = json_decode($response, true);
        
        if ($responseArray !== null) {
            echo "API Response: <pre>" . print_r($responseArray, true) . "</pre>";
        } else {
            echo "Error decoding API response JSON.";
        }
    }


    curl_close($ch);

}
?>
