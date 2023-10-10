<?php
session_start();

$response = array();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === 1) {
    $response['loggedin'] = true;
    $response['redirect'] = 'mypets.php';
} else {
    $response['loggedin'] = false;
    $response['redirect'] = 'login.php';
}

header('Content-Type: application/json');
echo json_encode($response);
?>