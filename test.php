<?php

require_once 'connect.php';

session_start();


 $pinQuery = "SELECT pin_value FROM pins LIMIT 1";
    $pinResult = $connection->query($pinQuery);

    if ($pinResult && $pinResult->num_rows > 0) {
        $pinRow = $pinResult->fetch_assoc();
        $pinValue = $pinRow['pin_value'];

        // Send the PIN to the user's mobile number
        $message = "Your authentication PIN is: $pinValue";
        // sendPinToMobile($mobileNumber, $message);
        echo $message;


        echo "PIN sent successfully.";
    } else {
        echo "Error fetching PIN from the database.";
    }
    ?>