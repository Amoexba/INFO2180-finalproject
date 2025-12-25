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

/* ADD CONTACT */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("
        INSERT INTO Contacts
        (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
    ");

    $stmt->execute([
        $_POST['title'],
        $_POST['firstname'],
        $_POST['lastname'],
        $_POST['email'],
        $_POST['telephone'],
        $_POST['company'],
        $_POST['type'],
        $_POST['assigned_to'],
        $_SESSION['user_id']
    ]);

    echo json_encode(['message' => 'Contact added']);
    exit;
}

/* GET CONTACT(S) */
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM Contacts WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    exit;
}

$stmt = $conn->query("SELECT * FROM Contacts ORDER BY created_at DESC");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
