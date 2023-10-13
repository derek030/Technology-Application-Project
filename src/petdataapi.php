<?php
// Connect to the database
require_once('databaseConfig.php');

// Check the database connection
if ($conn->connect_error) {
    $response_data = array(
        "message" => "Database connection failed."
    );
} else {
    // Query to get all pet data
    $query = "SELECT * FROM pet"; // Updated table name to "pet"
    $result = $conn->query($query);

    if ($result) {
        $pets = array();
        while ($row = $result->fetch_assoc()) {
            $pet = array(
                "id" => $row['id'],
                "name" => $row['name'],
                "type" => $row['type'],
                "owner_id" => $row['owner_id'],
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
}

header('Content-Type: application/json');
echo json_encode($response_data);
mysqli_close($conn);
?>
