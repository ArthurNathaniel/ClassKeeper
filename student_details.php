<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch student details by ID
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $student = $stmt->fetch();

    if ($student) {
        echo "<p><strong>Full Name:</strong> " . $student['full_name'] . "</p>";
        echo "<p><strong>Date of Birth:</strong> " . $student['dob'] . "</p>";
        echo "<p><strong>Gender:</strong> " . $student['gender'] . "</p>";
        echo "<p><strong>Email Address:</strong> " . $student['email'] . "</p>";
        echo "<p><strong>Phone Number:</strong> " . $student['phone'] . "</p>";
        echo "<p><strong>Address:</strong> " . $student['address'] . "</p>";
        echo "<p><strong>Mother's Name:</strong> " . $student['mother_name'] . "</p>";
        echo "<p><strong>Mother's Phone Number:</strong> " . $student['mother_number'] . "</p>";
        echo "<p><strong>Father's Name:</strong> " . $student['father_name'] . "</p>";
        echo "<p><strong>Father's Phone Number:</strong> " . $student['father_number'] . "</p>";
        echo "<p><strong>Assigned Class:</strong> " . $student['assigned_class'] . "</p>";
        echo "<p><strong>Profile Picture:</strong><br><img src='" . $student['profile_picture'] . "' alt='Profile Picture' style='width:100px;height:100px;'></p>";
    } else {
        echo "Student not found.";
    }
}
?>
