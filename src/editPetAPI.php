<?php
//use session to carry forward user email for creating pet profile
session_start();
//$loginEmail = $_SESSION['email'];
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
    $pName = mb_strtolower($_POST['petNameField']);
    $pAge = $_POST['petAgeField'];
    $owner = $loginEmail;
    if($_POST['petAgeUnitField']=='Years Old'){
        $pAgeUnit = 'Y';
    } else {$pAgeUnit = 'W';}
    $pGender =$_POST['petGenderField'];
    $pWeight = $_POST['petWeightField'];
    $pBreed = $_POST['petBreedField'];
    //adding new pet
       if (isset($_GET['action'])&&$_GET['action']=='add') {
        //check uniqueness    
        $checkPet = mysqli_query($conn, "SELECT * FROM pet WHERE owner = '$owner' AND name = '$pName'");
            $num = mysqli_num_rows($checkPet);

               if ($num == 1) {
                       $response_data = array(
                      "message" => "Invalid input. Pet already exists."
                    );
               } else {
                     $sqlstring = "INSERT INTO pet (name, age, ageUnit, gender, weight, breed, owner) 
                     VALUES ('$pName', '$pAge', '$pAgeUnit', '$pGender', '$pWeight', '$pBreed', '$owner')";
                     $result = mysqli_query($conn, $sqlstring);

                  if ($result) {
                     $result_data = array {
                        "pet" => $pName,
                        "Owner" => $owner
                     }
                          $response_data = array(
                             "message" => "Successfully added. You can now make a booking for your pet.",
                             "data" => $result_data
                           );
                   } else {
                        $response_data = array("message" => "Something went wrong.");
                     }
               }
       }else {
          //edit existing pet
                  $sqlstring = "UPDATE pet SET age='$pAge', ageUnit='$pAgeUnit', gender = '$pGender', weight= '$pWeight', 
                  breed = '$pBreed' WHERE name = '$pName' AND owner = '$owner')";
                  $editPet = mysqli_query($conn, $sqlstring);
                         if($editPet == 1) {
                             $response_data = array(
                                "message" => "Update successfully."
                                );
                          } else if ($editPet == 0){
                            $response_data = array(
                                "message" => "No record was found."
                                );
                          }else {$response_data = array("message" => "Something went wrong.");
                        }
            }
}
header('Content-Type: application/json'); // Fix the header
echo json_encode($response_data);
mysqli_close($conn);

?>