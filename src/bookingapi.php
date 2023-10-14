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
    $customerName = $_POST['customerName'];
    $email = $_POST['email'];
    $petName = $_POST['petName'];
    $bookingDate = $_POST['bookingDate'];
    $bookingTime = $_POST['bookingTime'];
    $service = isset($_POST['service']) ? $_POST['service'] : [];
    $amount = $_POST['amount'];
    $payment = $_POST['payment']; // Added to get payment amount

    // Example: Inserting into a bookings table
    $sqlstring = "INSERT INTO booking (customername, email, petname, service, bookingdatetime, amount, payment) 
         VALUES ('$customerName', '$email', '$petName', '$service', STR_TO_DATE('$bookingDate $bookingTime', '%Y-%m-%d %H:%i'), '$amount', '$payment')";
    $result = mysqli_query($conn, $sqlstring);

    if ($result) {
        $result_data = array(
            "customer" => $customerName,
            "email" => $email,
            "petName" => $petName,
            "bookingDate" => $bookingDate,
            "bookingTime" => $bookingTime,
            "services" => $service,
            "paymentAmount" => $amount
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
