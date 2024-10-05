<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->rowCount() > 0) {
        $error = "Email already exists. Please use a different one.";
    } else {
        $stmt = $conn->prepare("INSERT INTO admins (email, password) VALUES (:email, :password)");
        if ($stmt->execute(['email' => $email, 'password' => $password])) {
            header("Location: login.php");
            exit(); 
        } else {
            $error = "Signup failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - ClassKeeper</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
<div class="login_all">
      <div class="login_box">
      <div class="forms_title">
    <h2>Admin Signup</h2>
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
     <button type="submit">Signup</button>
     </div>
    </form>
    </div>
    </div>
</body>
</html>
