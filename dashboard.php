<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'db.php';

// Fetch data for charts
$totalStudentsQuery = $conn->query("SELECT COUNT(*) AS total FROM students");
$totalStudents = $totalStudentsQuery->fetchColumn();

$genderQuery = $conn->query("SELECT gender, COUNT(*) AS count FROM students GROUP BY gender");
$genderData = $genderQuery->fetchAll(PDO::FETCH_ASSOC);

$classQuery = $conn->query("SELECT assigned_class, COUNT(*) AS count FROM students GROUP BY assigned_class");
$classData = $classQuery->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for charts
$genderLabels = [];
$genderCounts = [];
foreach ($genderData as $row) {
    $genderLabels[] = $row['gender'];
    $genderCounts[] = $row['count'];
}

$classLabels = [];
$classCounts = [];
foreach ($classData as $row) {
    $classLabels[] = $row['assigned_class'];
    $classCounts[] = $row['count'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ClassKeeper</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['email']; ?></h2>
    <p>This is your admin dashboard.</p>

    <h3>Total Number of Students: <?php echo $totalStudents; ?></h3>

    <h3>Gender Distribution</h3>
    <canvas id="genderChart" width="400" height="200"></canvas>

    <h3>Total Students in Each Class</h3>
    <canvas id="classChart" width="400" height="200"></canvas>

    <script>
        // Gender Distribution Chart
        const ctxGender = document.getElementById('genderChart').getContext('2d');
        const genderChart = new Chart(ctxGender, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($genderLabels); ?>,
                datasets: [{
                    label: 'Gender Distribution',
                    data: <?php echo json_encode($genderCounts); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Gender Distribution'
                    }
                }
            }
        });

        // Total Students in Each Class Chart
        const ctxClass = document.getElementById('classChart').getContext('2d');
        const classChart = new Chart(ctxClass, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($classLabels); ?>,
                datasets: [{
                    label: 'Number of Students',
                    data: <?php echo json_encode($classCounts); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Total Students in Each Class'
                    }
                }
            }
        });
    </script>
</body>
</html>
