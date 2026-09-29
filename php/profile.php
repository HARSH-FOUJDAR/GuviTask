<?php

session_start();

header("Content-Type: application/json");

include "db.php";


if (!isset($_SESSION["user_id"])) {

    echo json_encode([
        "success" => false,
        "message" => "Please login first"
    ]);

    exit;
}


$userId = $_SESSION["user_id"];


$sql = "SELECT id, name, email, Mobile, DOB, DateTime
        FROM userdata
        WHERE id = ?";

$stmt = $conn->prepare($sql);



if (!$stmt) {

    echo json_encode([
        "success" => false,
        "message" => "Database query failed"
    ]);

    exit;
}

$stmt->bind_param("i", $userId);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 1) {

    $user = $result->fetch_assoc();


  
    echo json_encode([
        "success" => true,
        "data" => [
            "id" => $user["id"],
            "name" => $user["name"],
            "email" => $user["email"],
            "Mobile" => $user["Mobile"],
            "DOB" => $user["DOB"],
            "DateTime" => $user["DateTime"]
        ]
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "User not found"
    ]);
}


$stmt->close();
$conn->close();

?>