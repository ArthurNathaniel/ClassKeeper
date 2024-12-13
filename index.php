<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassKeeper - The Ultimate Class & Student Management Tool</title>
    <meta name="description" content="ClassKeeper is a powerful tool for managing students and classes, offering a user-friendly experience for administrators and teachers.">
    <meta name="keywords" content="class management, student management, school admin, class tracker, education software, school management system, ClassKeeper">
    <meta name="author" content="Yakubu AbdulRazak">
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>

    <div class="container">
        <div class="logo"></div>
        <h1 class="title">Welcome to ClassKeeper</h1>
        <p>Your ultimate tool for managing classes and students.</p>
        <button class="login-btn" onclick="window.location.href='login.php'">Login</button>
    </div>

    <script>
        anime({
            targets: '.logo',
            translateY: [-100, 0],
            opacity: [0, 1],
            easing: 'easeOutElastic(4, .8)',
            duration: 2000,
            delay: 400
        });
        anime({
            targets: '.title',
            translateY: [-100, 0],
            opacity: [0, 1],
            easing: 'easeOutElastic(1, .8)',
            duration: 2000,
            delay: 300
        });

        anime({
            targets: '.login-btn',
            translateY: [-100, 0],
            opacity: [0, 1],
            easing: 'easeInElastic(1, .8)',
            duration: 2000,
            delay: 300
        });
    </script>
</body>

</html>