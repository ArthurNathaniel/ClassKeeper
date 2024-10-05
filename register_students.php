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

 
    $profile_picture = '';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $profile_picture = 'uploads/' . basename($_FILES['profile_picture']['name']);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture);
    }

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Student - ClassKeeper</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/register_students.css">
</head>

<body>
    <?php include 'sidebar.php' ?>
    <div class="register_students_all">
       <div class="forms">
       <h2>Register Student</h2>
       </div>
        <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="forms_group">
                <div class="forms">
                    <label>Full Name:</label>
                    <input type="text" name="full_name" required>
                </div>

                <div class="forms">
                    <label>Date of Birth:</label>
                    <input type="date" name="dob" required>
                </div>

                <div class="forms">
                    <label>Gender:</label>
                    <select name="gender" required>
                    <option value="" hidden>Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="forms">
                    <label>Email Address:</label>
                    <input type="email" name="email" required>
                </div>

                <div class="forms">
                    <label>Phone Number:</label>
                    <input type="text" name="phone" required>
                </div>
                <div class="forms">
                    <label>Address:</label>
                    <input type="text" name="address" required>
                </div>

                <div class="forms">
                    <label>Mother's Name:</label>
                    <input type="text" name="mother_name" required>
                </div>

                <div class="forms">
                    <label>Mother's Phone Number:</label>
                    <input type="text" name="mother_number" required>
                </div>

                <div class="forms">
                    <label>Father's Name:</label>
                    <input type="text" name="father_name" required>
                </div>

                <div class="forms">
                    <label>Father's Phone Number:</label>
                    <input type="text" name="father_number" required>
                </div>
                <div class="forms">

                    <label>Assigned Class:</label>
                    <select name="assigned_class" required>
                        <option value="" hidden>Select class</option>
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
                    </select>
                </div>

                <div class="forms">
                    <label>Profile Picture:</label>
                    <input type="file" name="profile_picture" accept="image/*" required>
                </div>

                <div class="forms">
                    <button type="submit">Register Student</button>
                </div>
        </form>
    </div>
    </div>
</body>

</html>