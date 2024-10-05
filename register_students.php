<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $mother_name = $_POST['mother_name'];
    $mother_number = $_POST['mother_number'];
    $father_name = $_POST['father_name'];
    $father_number = $_POST['father_number'];
    $assigned_class = $_POST['assigned_class'];

    // Handle profile picture upload
    $profile_picture = '';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $profile_picture = 'uploads/' . basename($_FILES['profile_picture']['name']);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture);
    }

    // Insert student into the database
    $stmt = $conn->prepare("INSERT INTO students (full_name, dob, gender, email, phone, address, mother_name, mother_number, father_name, father_number, assigned_class, profile_picture) 
    VALUES (:full_name, :dob, :gender, :email, :phone, :address, :mother_name, :mother_number, :father_name, :father_number, :assigned_class, :profile_picture)");

    $stmt->execute([
        'full_name' => $full_name,
        'dob' => $dob,
        'gender' => $gender,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'mother_name' => $mother_name,
        'mother_number' => $mother_number,
        'father_name' => $father_name,
        'father_number' => $father_number,
        'assigned_class' => $assigned_class,
        'profile_picture' => $profile_picture
    ]);

    $success = "Student registered successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Student - ClassKeeper</title>
</head>
<body>
    <h2>Register Student</h2>
    <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <label>Full Name:</label>
        <input type="text" name="full_name" required><br>

        <label>Date of Birth:</label>
        <input type="date" name="dob" required><br>

        <label>Gender:</label>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br>

        <label>Email Address:</label>
        <input type="email" name="email" required><br>

        <label>Phone Number:</label>
        <input type="text" name="phone" required><br>

        <label>Address:</label>
        <textarea name="address" required></textarea><br>

        <label>Mother's Name:</label>
        <input type="text" name="mother_name" required><br>

        <label>Mother's Phone Number:</label>
        <input type="text" name="mother_number" required><br>

        <label>Father's Name:</label>
        <input type="text" name="father_name" required><br>

        <label>Father's Phone Number:</label>
        <input type="text" name="father_number" required><br>

        <label>Assigned Class:</label>
        <select name="assigned_class" required>
            <option value="Form 1 - General Art 1">Form 1 - General Art 1</option>
            <option value="Form 1 - General Art 2">Form 1 - General Art 2</option>
            <option value="Form 1 - General Art 3">Form 1 - General Art 3</option>
            <option value="Form 1 - Business 1">Form 1 - Business 1</option>
            <option value="Form 1 - Business 2">Form 1 - Business 2</option>
            <option value="Form 1 - Science 1">Form 1 - Science 1</option>
            <option value="Form 1 - Science 2">Form 1 - Science 2</option>

            <option value="Form 2 - General Art 1">Form 2 - General Art 1</option>
            <option value="Form 2 - General Art 2">Form 2 - General Art 2</option>
            <option value="Form 2 - General Art 3">Form 2 - General Art 3</option>
            <option value="Form 2 - Business 1">Form 2 - Business 1</option>
            <option value="Form 2 - Business 2">Form 2 - Business 2</option>
            <option value="Form 2 - Science 1">Form 2 - Science 1</option>
            <option value="Form 2 - Science 2">Form 2 - Science 2</option>

            <option value="Form 3 - General Art 1">Form 3 - General Art 1</option>
            <option value="Form 3 - General Art 2">Form 3 - General Art 2</option>
            <option value="Form 3 - General Art 3">Form 3 - General Art 3</option>
            <option value="Form 3 - Business 1">Form 3 - Business 1</option>
            <option value="Form 3 - Business 2">Form 3 - Business 2</option>
            <option value="Form 3 - Science 1">Form 3 - Science 1</option>
            <option value="Form 3 - Science 2">Form 3 - Science 2</option>
        </select><br>

        <label>Profile Picture:</label>
        <input type="file" name="profile_picture" accept="image/*" required><br>

        <button type="submit">Register Student</button>
    </form>
</body>
</html>
