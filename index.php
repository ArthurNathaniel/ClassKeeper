<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php"); // Redirect to dashboard if already logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - ClassKeeper</title>

    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">

    <style>
     
    </style>
</head>
<body>

    <div class="container">
        <div class="logo"></div>
        <h1 class="title">Welcome to ClassKeeper</h1>
        <p>Your ultimate tool for managing classes and students.</p>
        <button class="login-btn" onclick="window.location.href='login.php'">Login</button>
    </div>

    <script>
        // Text animation for title
        anime({
            targets: '.title',
            translateY: [-100, 0],  // Animate from -100px to 0px
            opacity: [0, 1],  // Animate from 0 to 1 opacity
            easing: 'easeOutElastic(1, .8)',  // Elastic easing
            duration: 2000,  // Duration of animation
            delay: 300  // Delay before starting
        });

        // Button bounce animation on hover
        document.querySelector('.login-btn').addEventListener('mouseenter', function () {
            anime({
                targets: '.login-btn',
                scale: 1.1,
                duration: 300,
                easing: 'easeOutElastic(1, .8)'
            });
        });

        document.querySelector('.login-btn').addEventListener('mouseleave', function () {
            anime({
                targets: '.login-btn',
                scale: 1,
                duration: 300,
                easing: 'easeOutElastic(1, .8)'
            });
        });
    </script>
</body>
</html>
