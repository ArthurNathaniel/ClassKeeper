<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->rowCount() > 0) {
        $error = "Email already exists. Please use a different one.";
    } else {
        // Insert new admin
        $stmt = $conn->prepare("INSERT INTO admins (email, password) VALUES (:email, :password)");
        if ($stmt->execute(['email' => $email, 'password' => $password])) {
            // Redirect to login page after successful signup
            header("Location: login.php");
            exit(); // Ensure the script stops after redirection
        } else {
            $error = "Signup failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup - ClassKeeper</title>
</head>
<body>
    <h2>Admin Signup</h2>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

    <form method="POST" action="">
        <label>Email:</label>
        <input type="email" name="email" required>
        <br>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Signup</button>
    </form>
</body>
</html>
