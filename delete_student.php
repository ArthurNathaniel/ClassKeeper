<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM students WHERE id = :id");
    $stmt->execute(['id' => $id]);

    echo "Student deleted successfully."; 
}
?>
