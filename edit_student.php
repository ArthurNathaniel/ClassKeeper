<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Fetch the student's current details
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $student = $stmt->fetch();
}

// Handle form submission to update student details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture form data and update the student record
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
    $profile_picture = $student['profile_picture']; // Default to the current picture
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        // If a new profile picture is uploaded, move it to the uploads directory
        $profile_picture = 'uploads/' . basename($_FILES['profile_picture']['name']);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture);
    }

    // Update student in the database
    $stmt = $conn->prepare("UPDATE students SET 
        full_name = :full_name, 
        dob = :dob, 
        gender = :gender, 
        email = :email, 
        phone = :phone, 
        address = :address, 
        mother_name = :mother_name, 
        mother_number = :mother_number, 
        father_name = :father_name, 
        father_number = :father_number, 
        assigned_class = :assigned_class, 
        profile_picture = :profile_picture 
        WHERE id = :id");

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
        'profile_picture' => $profile_picture,
        'id' => $id
    ]);

    header('Location: view_students.php'); // Redirect back to the student list
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - ClassKeeper</title>
</head>
<body>

    <h2>Edit Student</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($student['full_name']); ?>" required><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($student['dob']); ?>" required><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
        </select><br>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required><br>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>" required><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address" required><?php echo htmlspecialchars($student['address']); ?></textarea><br>

        <label for="mother_name">Mother's Name:</label>
        <input type="text" id="mother_name" name="mother_name" value="<?php echo htmlspecialchars($student['mother_name']); ?>" required><br>

        <label for="mother_number">Mother's Phone Number:</label>
        <input type="text" id="mother_number" name="mother_number" value="<?php echo htmlspecialchars($student['mother_number']); ?>" required><br>

        <label for="father_name">Father's Name:</label>
        <input type="text" id="father_name" name="father_name" value="<?php echo htmlspecialchars($student['father_name']); ?>" required><br>

        <label for="father_number">Father's Phone Number:</label>
        <input type="text" id="father_number" name="father_number" value="<?php echo htmlspecialchars($student['father_number']); ?>" required><br>

        <label for="assigned_class">Assigned Class:</label>
        <select id="assigned_class" name="assigned_class" required>
            <option value="Form 1 - General Art 1" <?php echo ($student['assigned_class'] == 'Form 1 - General Art 1') ? 'selected' : ''; ?>>Form 1 - General Art 1</option>
            <option value="Form 1 - General Art 2" <?php echo ($student['assigned_class'] == 'Form 1 - General Art 2') ? 'selected' : ''; ?>>Form 1 - General Art 2</option>
            <option value="Form 1 - General Art 3" <?php echo ($student['assigned_class'] == 'Form 1 - General Art 3') ? 'selected' : ''; ?>>Form 1 - General Art 3</option>
            <option value="Form 1 - Business 1" <?php echo ($student['assigned_class'] == 'Form 1 - Business 1') ? 'selected' : ''; ?>>Form 1 - Business 1</option>
            <option value="Form 1 - Business 2" <?php echo ($student['assigned_class'] == 'Form 1 - Business 2') ? 'selected' : ''; ?>>Form 1 - Business 2</option>
            <option value="Form 1 - Science 1" <?php echo ($student['assigned_class'] == 'Form 1 - Science 1') ? 'selected' : ''; ?>>Form 1 - Science 1</option>
            <option value="Form 1 - Science 2" <?php echo ($student['assigned_class'] == 'Form 1 - Science 2') ? 'selected' : ''; ?>>Form 1 - Science 2</option>

            <option value="Form 2 - General Art 1" <?php echo ($student['assigned_class'] == 'Form 2 - General Art 1') ? 'selected' : ''; ?>>Form 2 - General Art 1</option>
            <option value="Form 2 - General Art 2" <?php echo ($student['assigned_class'] == 'Form 2 - General Art 2') ? 'selected' : ''; ?>>Form 2 - General Art 2</option>
            <option value="Form 2 - General Art 3" <?php echo ($student['assigned_class'] == 'Form 2 - General Art 3') ? 'selected' : ''; ?>>Form 2 - General Art 3</option>
            <option value="Form 2 - Business 1" <?php echo ($student['assigned_class'] == 'Form 2 - Business 1') ? 'selected' : ''; ?>>Form 2 - Business 1</option>
            <option value="Form 2 - Business 2" <?php echo ($student['assigned_class'] == 'Form 2 - Business 2') ? 'selected' : ''; ?>>Form 2 - Business 2</option>
            <option value="Form 2 - Science 1" <?php echo ($student['assigned_class'] == 'Form 2 - Science 1') ? 'selected' : ''; ?>>Form 2 - Science 1</option>
            <option value="Form 2 - Science 2" <?php echo ($student['assigned_class'] == 'Form 2 - Science 2') ? 'selected' : ''; ?>>Form 2 - Science 2</option>

            <option value="Form 3 - General Art 1" <?php echo ($student['assigned_class'] == 'Form 3 - General Art 1') ? 'selected' : ''; ?>>Form 3 - General Art 1</option>
            <option value="Form 3 - General Art 2" <?php echo ($student['assigned_class'] == 'Form 3 - General Art 2') ? 'selected' : ''; ?>>Form 3 - General Art 2</option>
            <option value="Form 3 - General Art 3" <?php echo ($student['assigned_class'] == 'Form 3 - General Art 3') ? 'selected' : ''; ?>>Form 3 - General Art 3</option>
            <option value="Form 3 - Business 1" <?php echo ($student['assigned_class'] == 'Form 3 - Business 1') ? 'selected' : ''; ?>>Form 3 - Business 1</option>
            <option value="Form 3 - Business 2" <?php echo ($student['assigned_class'] == 'Form 3 - Business 2') ? 'selected' : ''; ?>>Form 3 - Business 2</option>
            <option value="Form 3 - Science 1" <?php echo ($student['assigned_class'] == 'Form 3 - Science 1') ? 'selected' : ''; ?>>Form 3 - Science 1</option>
            <option value="Form 3 - Science 2" <?php echo ($student['assigned_class'] == 'Form 3 - Science 2') ? 'selected' : ''; ?>>Form 3 - Science 2</option>

            <option value="Form 4 - General Art 1" <?php echo ($student['assigned_class'] == 'Form 4 - General Art 1') ? 'selected' : ''; ?>>Form 4 - General Art 1</option>
            <option value="Form 4 - General Art 2" <?php echo ($student['assigned_class'] == 'Form 4 - General Art 2') ? 'selected' : ''; ?>>Form 4 - General Art 2</option>
            <option value="Form 4 - General Art 3" <?php echo ($student['assigned_class'] == 'Form 4 - General Art 3') ? 'selected' : ''; ?>>Form 4 - General Art 3</option>
            <option value="Form 4 - Business 1" <?php echo ($student['assigned_class'] == 'Form 4 - Business 1') ? 'selected' : ''; ?>>Form 4 - Business 1</option>
            <option value="Form 4 - Business 2" <?php echo ($student['assigned_class'] == 'Form 4 - Business 2') ? 'selected' : ''; ?>>Form 4 - Business 2</option>
            <option value="Form 4 - Science 1" <?php echo ($student['assigned_class'] == 'Form 4 - Science 1') ? 'selected' : ''; ?>>Form 4 - Science 1</option>
            <option value="Form 4 - Science 2" <?php echo ($student['assigned_class'] == 'Form 4 - Science 2') ? 'selected' : ''; ?>>Form 4 - Science 2</option>

            <option value="Form 5 - General Art 1" <?php echo ($student['assigned_class'] == 'Form 5 - General Art 1') ? 'selected' : ''; ?>>Form 5 - General Art 1</option>
            <option value="Form 5 - General Art 2" <?php echo ($student['assigned_class'] == 'Form 5 - General Art 2') ? 'selected' : ''; ?>>Form 5 - General Art 2</option>
            <option value="Form 5 - General Art 3" <?php echo ($student['assigned_class'] == 'Form 5 - General Art 3') ? 'selected' : ''; ?>>Form 5 - General Art 3</option>
            <option value="Form 5 - Business 1" <?php echo ($student['assigned_class'] == 'Form 5 - Business 1') ? 'selected' : ''; ?>>Form 5 - Business 1</option>
            <option value="Form 5 - Business 2" <?php echo ($student['assigned_class'] == 'Form 5 - Business 2') ? 'selected' : ''; ?>>Form 5 - Business 2</option>
            <option value="Form 5 - Science 1" <?php echo ($student['assigned_class'] == 'Form 5 - Science 1') ? 'selected' : ''; ?>>Form 5 - Science 1</option>
            <option value="Form 5 - Science 2" <?php echo ($student['assigned_class'] == 'Form 5 - Science 2') ? 'selected' : ''; ?>>Form 5 - Science 2</option>
        </select><br>

        <label for="profile_picture">Profile Picture:</label>
        <input type="file" id="profile_picture" name="profile_picture"><br>
        <?php if ($student['profile_picture']): ?>
            <img src="<?php echo htmlspecialchars($student['profile_picture']); ?>" alt="Profile Picture" style="width: 100px; height: auto;"><br>
        <?php endif; ?>

        <input type="submit" value="Update Student">
    </form>

</body>
</html>
