<?php

session_start();

header("Content-Type: application/json");

include "db.php";


// Check login
if (!isset($_SESSION["user_id"])) {

    echo json_encode([
        "success" => false,
        "message" => "Please login first"
    ]);

    exit;
}



$userId = $_SESSION["user_id"];

$name = $_POST["name"] ?? "";
$email = $_POST["email"] ?? "";
$Mobile = $_POST["Mobile"] ?? "";
$DOB = $_POST["DOB"] ?? "";


if (
    $name == "" ||
    $email == "" ||
    $Mobile == "" ||
    $DOB == ""
) {

    echo json_encode([
        "success" => false,
        "message" => "All fields are required"
    ]);

    exit;
}

$sql = "UPDATE userdata
        SET name = ?,
            email = ?,
            Mobile = ?,
            DOB = ?
        WHERE id = ?";


$stmt = $conn->prepare($sql);


if (!$stmt) {

    echo json_encode([
        "success" => false,
        "message" => "Database query failed"
    ]);

    exit;
}


$stmt->bind_param(
    "ssssi",
    $name,
    $email,
    $Mobile,
    $DOB,
    $userId
);


if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Profile updated successfully"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Profile update failed"
    ]);
}


$stmt->close();
$conn->close();

?>