<?php

session_start();

header("Content-Type: application/json");

include "db.php";


// Get form data
$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";


// Check empty fields
if ($email == "" || $password == "") {

    echo json_encode([
        "success" => false,
        "message" => "Email and password are required"
    ]);

    exit;
}


// Find user by email
$sql = "SELECT id, name, email, password
        FROM userdata
        WHERE email = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $email);

$stmt->execute();

$result = $stmt->get_result();


// Check user exists
if ($result->num_rows != 1) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password"
    ]);

    exit;
}


// Get user data
$user = $result->fetch_assoc();


// Check password
if (!password_verify($password, $user["password"])) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password"
    ]);

    exit;
}


// Create PHP session
$_SESSION["user_id"] = $user["id"];


// Login successful
echo json_encode([
    "success" => true,
    "message" => "Login successful",
    "user_id" => $user["id"],
    "name" => $user["name"]
]);


// Close connection
$stmt->close();
$conn->close();

?>