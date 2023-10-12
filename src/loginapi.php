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
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM customer WHERE email='$email' AND password='$password'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {

                $row = mysqli_fetch_assoc($result);

                if ($row['email'] === $email && $row['password'] === $password) {

                        $result_data = array(
                                "email" => $row['email'],
                                "fname" => $row['fname'],
                                "lname" => $row['lname'],
                                "phone" => $row['phone'],
                                "addline1" => $row['addline1'],
                                "addline2" => $row['addline2'],
                                "suburb" => $row['suburb'],
                                "state" => $row['state'],
                                "postcode" => $row['postcode'],
                        );

                        $response_data = array(
                                "message" => "Successfully Login.",
                                "data" => $result_data
                        );
                }
        } else {
                $response_data = array("message" => "Incorrect email or password.");
        }

}


header('Content-Type: application/json'); // Fix the header
echo json_encode($response_data);
mysqli_close($conn);

?>