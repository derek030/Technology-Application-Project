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
    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $email = $_POST['email'];
    $pwd =$_POST['password'];
    $contact = $_POST['contactNumber'];
    $firstAdd = $_POST['streetAddress1'];
    $secondAdd = $_POST['streetAddress2'];
    $suburb = $_POST['suburb'];
    $state = $_POST['state'];
    $postcode = $_POST['postcode'];

    $checkEmail = mysqli_query($conn, "SELECT * FROM customer WHERE email = '$email'");
    $num = mysqli_num_rows($checkEmail);

    if ($num == 1) {
        $response_data = array(
            "message" => "Invalid email. User already exists."
        );
    } else {
        $sqlstring = "INSERT INTO customer (email, fname, lname, password, phone, addline1, addline2, suburb, state, postcode) 
             VALUES ('$email', '$fname', '$lname', '$pwd', '$contact', '$firstAdd', '$secondAdd', '$suburb', '$state', '$postcode')";
        $result = mysqli_query($conn, $sqlstring);

        if ($result) {
            $result_data = array(
                "customer" => $fname . ' ' . $lname,
                "Email" => $email
            );
            $response_data = array(
                "message" => "Successfully registered. Please Login.",
                "data" => $result_data
            );
        } else {
            $response_data = array("message" => "Something went wrong.");
        }
    }
}

header('Content-Type: application/json'); // Fix the header
echo json_encode($response_data);
mysqli_close($conn);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>