<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id']; 
        $_SESSION['email'] = $admin['email'];
        header("Location: dashboard.php"); 
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ClassKeeper</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <div class="login_all">
      <div class="login_box">
      <div class="logo"></div>
      <div class="forms_title">
            <h2>Admin Login</h2>
        </div>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

        <form method="POST" action="">
            <div class="forms">
                <label>Email:</label>
                <input type="email" placeholder="Enter your email address" name="email" required>
            </div>
            <div class="forms">
                <label>Password:</label>
                <input type="password" placeholder="Enter your password" name="password" required>
            </div>

            <div class="forms">
                <button type="submit">Login</button>
            </div>
        </form>
      </div>
    </div>
</body>

</html>