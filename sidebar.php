<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
?>

<div class="navbar_all">

    <button id="toggleButton">
        <i class="fa-solid fa-bars-staggered"></i>
    </button>
    <div class="logout">
        <a href="logout.php" class="<?= $current_page === 'logout.php' ? 'active' : '' ?>">Logout</a>
    </div>


    <div class="mobile">
        <div class="logo"></div>
        <a href="dashboard.php" class="<?= $current_page === 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
        <a href="register_students.php" class="<?= $current_page === 'register_students.php' ? 'active' : '' ?>">Register Student</a>
        <a href="view_students.php" class="<?= $current_page === 'view_students.php' ? 'active' : '' ?>">View Students</a>

    </div>

</div>


<script>
    var toggleButton = document.getElementById("toggleButton");
    var sidebar = document.querySelector(".mobile");
    var icon = toggleButton.querySelector("i");

    toggleButton.addEventListener("click", function() {
        if (sidebar.style.display === "none" || sidebar.style.display === "") {
            sidebar.style.display = "flex";
            sidebar.style.flexDirection = "column";
            icon.classList.remove("fa-bars-staggered");
            icon.classList.add("fa-xmark");
        } else {
            sidebar.style.display = "none";
            icon.classList.remove("fa-xmark");
            icon.classList.add("fa-bars-staggered");
        }
    });
</script>