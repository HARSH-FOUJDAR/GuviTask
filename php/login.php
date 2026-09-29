<?php

session_start();

header("Content-Type: application/json");

include "db.php";



$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";



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


if ($result->num_rows != 1) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password"
    ]);

    exit;
}


$user = $result->fetch_assoc();


if (!password_verify($password, $user["password"])) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password",
      
    ]);

    exit;
}


$_SESSION["user_id"] = $user["id"];



echo json_encode([
    "success" => true,
    "message" => "Login successful",
    "user_id" => $user["id"],
    "name" => $user["name"]
]);



$stmt->close();
$conn->close();

?>