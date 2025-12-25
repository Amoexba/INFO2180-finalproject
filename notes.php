<?php
session_start();
require 'database.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

/* ADD NOTE */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("
        INSERT INTO Notes (contact_id, comment, created_by, created_at)
        VALUES (?, ?, ?, NOW())
    ");

    $stmt->execute([
        $_POST['contact_id'],
        $_POST['comment'],
        $_SESSION['user_id']
    ]);

    echo json_encode(['message' => 'Note added']);
    exit;
}

/* GET NOTES */
if (!isset($_GET['contact_id'])) {
    echo json_encode([]);
    exit;
}

$stmt = $conn->prepare("
    SELECT Notes.comment, Notes.created_at, Users.firstname, Users.lastname
    FROM Notes
    JOIN Users ON Notes.created_by = Users.id
    WHERE contact_id = ?
    ORDER BY Notes.created_at DESC
");
$stmt->execute([$_GET['contact_id']]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
