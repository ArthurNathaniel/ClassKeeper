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
   
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/dashboard.css">
</head>
<body>
<?php include 'sidebar.php' ?>
<div class="dashboard_all">

 <div class="charts">

 <h3>Total Number of Students:</h3>
 <h1> <?php echo $totalStudents; ?></h1>
 </div>
<div class="chart"> 
<h3>Gender Distribution</h3>
<canvas id="genderChart" width="400" height="200"></canvas>
</div>
<div class="chart">
<h3>Total Students in Each Class</h3>
<canvas id="classChart" width="400" height="200"></canvas>
</div>
   </div>

    <script>
        const ctxGender = document.getElementById('genderChart').getContext('2d');
        const genderChart = new Chart(ctxGender, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($genderLabels); ?>,
                datasets: [{
                    label: 'Gender Distribution',
                    data: <?php echo json_encode($genderCounts); ?>,
                    backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(153, 102, 255)',
                                'rgb(255, 159, 64)'
                            ],
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

        const ctxClass = document.getElementById('classChart').getContext('2d');
        const classChart = new Chart(ctxClass, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($classLabels); ?>,
                datasets: [{
                    label: 'Number of Students',
                    data: <?php echo json_encode($classCounts); ?>,
                    backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(153, 102, 255)',
                                'rgb(255, 159, 64)'
                            ],
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
