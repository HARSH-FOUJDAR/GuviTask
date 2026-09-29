<?php

header("Content-Type: application/json");

include "db.php";

$name = $_POST["name"] ?? "";
$email = $_POST["email"] ?? "";
$Mobile = $_POST["Mobile"] ?? "";
$DOB = $_POST["DOB"] ?? "";
$password = $_POST["password"] ?? "";

if ($name == "" || $email == "" || $Mobile == "" || $DOB == "" || $password == "") {

    echo json_encode([
        "success" => false,
        "message" => "All fields are required"
    ]);

    exit;
}


// Check email
$sql = "SELECT id FROM userdata WHERE email = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $email);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    echo json_encode([
        "success" => false,
        "message" => "Email already registered"
    ]);

    exit;
}



$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);



$sql = "INSERT INTO `userdata` (name, email, Mobile, DOB, password)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "sssss",
    $name,
    $email,
    $Mobile,
    $DOB,
    $hashedPassword
);


if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Registration successful"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Registration failed"
    ]);
}


$stmt->close();
$conn->close();

?>