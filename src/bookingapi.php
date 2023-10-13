<?php
// Connect to the database
require_once('databaseConfig.php');

parse_str(file_get_contents("php://input"), $_POST);

// Check if JSON decoding was successful
if ($_POST === null) {
    $response_data = array(
        "message" => "Invalid input data."
    );
} else {
    // Data fields should be accessed like this:
    $petName = $_POST['pet-name'];
    $bookingDate = $_POST['booking-date'];
    $bookingTime = $_POST['booking-time'];
    $services = isset($_POST['services']) ? $_POST['services'] : [];
    $cardNumber = $_POST['card-number'];
    $cardholderName = $_POST['cardholder-name'];
    $expiration = $_POST['expiration'];
    $cvc = $_POST['cvc'];
    $paymentAmount = $_POST['payment-amount']; // Added to get payment amount

    // Example: Inserting into a bookings table
    $sqlstring = "INSERT INTO bookings (pet_name, booking_date, booking_time, services, card_number, cardholder_name, expiration, cvc, payment) 
         VALUES ('$petName', '$bookingDate', '$bookingTime', '" . implode(", ", $services) . "', '$cardNumber', '$cardholderName', '$expiration', '$cvc', '$paymentAmount')";
    $result = mysqli_query($conn, $sqlstring);

    if ($result) {
        $result_data = array(
            "petName" => $petName,
            "bookingDate" => $bookingDate,
            "bookingTime" => $bookingTime,
            "services" => $services,
            "paymentAmount" => $paymentAmount
        );
        $response_data = array(
            "message" => "Booking successful.",
            "data" => $result_data
        );
    } else {
        $response_data = array("message" => "Booking failed. Something went wrong.");
    }
}

header('Content-Type: application/json');
echo json_encode($response_data);
mysqli_close($conn);
?>
