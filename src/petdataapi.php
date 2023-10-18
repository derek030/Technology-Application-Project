<?php
// Connect to the database
require_once('databaseConfig.php');

// Check the database connection
if ($conn->connect_error) {
    $response_data = array(
        "message" => "Database connection failed."
    );
} else if(isset($_GET['email'])){
    $email = $_GET['email'];

    // Query to get all pet data
    $query = "SELECT * FROM pet WHERE owner = '$email'"; // Updated table name to "pet"
    $result = $conn->query($query);

    if ($result) {
        $pets = array();
        while ($row = $result->fetch_assoc()) {
            $pet = array(
                "id" => $row['id'],
                "name" => $row['name'],
                "age" => $row['age'],
                "ageUnit" => $row['ageUnit'],
                "gender" => $row['gender'],
                "breed" => $row['breed'],
                "photo" => $row['photo'],
                "owner" => $row['owner'],
                "vaccination" => $row['vaccination'],
                "weight" => $row['weight']
                // Add other fields as needed
            );
            $pets[] = $pet;
        }

        $response_data = array(
            "message" => "Successfully fetched pet data.",
            "data" => $pets
        );
    } else {
        $response_data = array(
            "message" => "Failed to fetch pet data."
        );
    }
} else {
    $pid = $_GET['petid'];
    $query = "SELECT photo FROM pet WHERE id = '$pid'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $imgsrc = $row['photo'];
    $reponse_data = array (
    "imgsrc" => $imgsrc
    );
}

header('Content-Type: application/json');
echo json_encode($response_data);
mysqli_close($conn);
?>
