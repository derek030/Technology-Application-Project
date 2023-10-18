<?php
//include 'upload.php';
//use session to carry forward user email for creating pet profile
session_start();
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
    $pName = mb_strtolower($_POST['petName']);
    $pAge = $_POST['petAge'];
    $owner = $_POST['owner'];
    if($_POST['ageUnit']=='Years Old'){
        $pAgeUnit = 'Y';
    } else {$pAgeUnit = 'W';}
    $pGender =$_POST['petGender'];
    $pWeight = $_POST['petWeight'];
    $pBreed = $_POST['petBreed'];
    $action = $_POST['Action'];
    $petID = (int)$_POST['petId'];
    $imgURL = $_POST['imgFile'];
    $fileURL = $_POST['vaccination'];

    //adding new pet
       if ($action=='add') {
        //check uniqueness    
        $checkPet = mysqli_query($conn, "SELECT * FROM pet WHERE owner = '$owner' AND name = '$pName'");
            $num = mysqli_num_rows($checkPet);
          
               if ($num == 1) {
                       $response_data = array(
                      "message" => "Invalid input. Pet already exists."
                    );
               } else {
                     $sqlstring = "INSERT INTO pet (name, age, ageUnit, gender, weight, breed,photo,vaccination, owner) 
                     VALUES ('$pName', '$pAge', '$pAgeUnit', '$pGender', '$pWeight', '$pBreed','$imgURL','$fileURL', '$owner')";
                     $result = mysqli_query($conn, $sqlstring);
                  if ($result==1) {
                     $result_data = array (
                        "pet" => $pName,
                        "Owner" => $owner
                     );
                          $response_data = array(
                             "message" => "Successfully added. You can now make a booking for your pet.",
                             "data" => $result_data
                           );
                   } else {
                        $response_data = array("message" => "Something went wrong.");
                     }
               }
       }else if($action=='edit'){    
                
          //edit existing pet
                  $sqlstring = "UPDATE pet SET name = '$pName', age='$pAge', ageUnit='$pAgeUnit', gender = '$pGender', weight= '$pWeight', breed = '$pBreed' ,photo = '$imgURL',vaccination='$fileURL'  WHERE id = $petID";
                  $editPet = mysqli_query($conn, $sqlstring);
                         if($editPet == 1) {
                            $result_data = array (
                                "pet" => $pName,
                                 "petid" => $petID,
                                "Owner" => $owner
                             );
                             $response_data = array(
                                "message" => "Update successfully.",
                                "data" => $result_data
                                );
                          } else if ($editPet == 0){
                            $response_data = array(
                                "message" => "No record was found."
                                );
                          }else {
                            $response_data = array(
                                "message" => "Something went wrong."
                            );
                        }
            }
}
header('Content-Type: application/json'); // Fix the header
echo json_encode($response_data);
mysqli_close($conn);

?>