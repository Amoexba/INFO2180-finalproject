<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$conn = new mysqli("localhost", "root", "", "dolphin_crm");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "DB connection failed"]);
    exit();
}

$filter = $_GET['filter'] ?? 'all';
$userId = $_SESSION['user_id'];

$sql = "SELECT id, title, firstname, lastname, email, company, type 
        FROM contacts";

if ($filter === "sales") {
    $sql .= " WHERE type = 'Sales Lead'";
} elseif ($filter === "support") {
    $sql .= " WHERE type = 'Support'";
} elseif ($filter === "mine") {
    $sql .= " WHERE assigned_to = ?";
}

$stmt = $conn->prepare($sql);

if ($filter === "mine") {
    $stmt->bind_param("i", $userId);
}

$stmt->execute();
$result = $stmt->get_result();

$contacts = [];
while ($row = $result->fetch_assoc()) {
    $contacts[] = $row;
}

header("Content-Type: application/json");
echo json_encode($contacts);

$stmt->close();
$conn->close();
?>
