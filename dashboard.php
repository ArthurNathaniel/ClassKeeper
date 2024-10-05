<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - ClassKeeper</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['email']; ?></h2>
    <p>This is your admin dashboard.</p>
</body>
</html>
