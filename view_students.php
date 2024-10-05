<?php
include 'db.php';

// Fetch all students from the database
$stmt = $conn->prepare("SELECT id, full_name, gender, assigned_class FROM students");
$stmt->execute();
$students = $stmt->fetchAll();

// Fetch unique classes for the filter
$classStmt = $conn->prepare("SELECT DISTINCT assigned_class FROM students");
$classStmt->execute();
$classes = $classStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students - ClassKeeper</title>
    <style>
        /* Basic styles for the table and modal */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 10px;
        }

        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 100px;
        }

        .modal-content {
            background-color: white;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: red;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover, .close:focus {
            color: black;
            cursor: pointer;
        }

        .action-buttons button {
            margin-right: 5px;
        }

        #noResults {
            color: red;
            font-weight: bold;
            display: none; /* Hidden by default */
            margin-top: 10px;
        }

        #classFilter {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <h2>Students List</h2>

    <!-- Class Filter Dropdown -->
    <select id="classFilter" onchange="filterByClass()">
        <option value="">All Classes</option>
        <?php foreach ($classes as $class): ?>
            <option value="<?php echo htmlspecialchars($class); ?>"><?php echo htmlspecialchars($class); ?></option>
        <?php endforeach; ?>
    </select>

    <!-- Search Input -->
    <input type="text" id="searchInput" onkeyup="searchStudents()" placeholder="Search for names..">

    <table id="studentsTable">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Class</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                <td><?php echo htmlspecialchars($student['assigned_class']); ?></td>
                <td><?php echo htmlspecialchars($student['gender']); ?></td>
                <td class="action-buttons">
                    <button onclick="openModal(<?php echo $student['id']; ?>)">View</button>
                    <button onclick="editStudent(<?php echo $student['id']; ?>)">Edit</button>
                    <button onclick="deleteStudent(<?php echo $student['id']; ?>)">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- No Results Message -->
    <div id="noResults">No students found matching your search.</div>

    <!-- The Modal -->
    <div id="studentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Student Details</h3>
            <div id="studentDetails"></div>
        </div>
    </div>

    <script>
        // Function to open the modal and fetch student details via AJAX
        function openModal(studentId) {
            document.getElementById('studentModal').style.display = 'block';
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'student_details.php?id=' + studentId, true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    document.getElementById('studentDetails').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('studentModal').style.display = 'none';
        }

        // Function to edit a student
        function editStudent(studentId) {
            window.location.href = 'edit_student.php?id=' + studentId; // Redirect to edit page
        }

        // Function to delete a student
        function deleteStudent(studentId) {
            if (confirm("Are you sure you want to delete this student?")) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_student.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status == 200) {
                        alert("Student deleted successfully.");
                        window.location.reload(); // Reload the page to see the updated list
                    } else {
                        alert("Error deleting student.");
                    }
                };
                xhr.send('id=' + studentId);
            }
        }

        // Close the modal if the user clicks anywhere outside of the modal
        window.onclick = function(event) {
            if (event.target == document.getElementById('studentModal')) {
                closeModal();
            }
        }

        // Function to search students
        function searchStudents() {
            var input = document.getElementById('searchInput');
            var filter = input.value.toLowerCase();
            var table = document.getElementById('studentsTable');
            var trs = table.getElementsByTagName('tr');
            var noResults = document.getElementById('noResults');
            var resultFound = false;

            for (var i = 1; i < trs.length; i++) { // Start at 1 to skip the header
                var tds = trs[i].getElementsByTagName('td');
                var found = false;

                for (var j = 0; j < tds.length; j++) {
                    if (tds[j].innerText.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }

                trs[i].style.display = found ? '' : 'none';
                if (found) {
                    resultFound = true; // At least one result found
                }
            }

            // Show or hide the no results message
            noResults.style.display = resultFound ? 'none' : 'block';
        }

        // Function to filter students by class
        function filterByClass() {
            var select = document.getElementById('classFilter');
            var selectedClass = select.value.toLowerCase();
            var table = document.getElementById('studentsTable');
            var trs = table.getElementsByTagName('tr');
            var noResults = document.getElementById('noResults');
            var resultFound = false;

            for (var i = 1; i < trs.length; i++) { // Start at 1 to skip the header
                var tds = trs[i].getElementsByTagName('td');
                var classCell = tds[1].innerText.toLowerCase(); // Class is in the second column

                // Check if the class matches the selected class
                if (selectedClass === '' || classCell.indexOf(selectedClass) > -1) {
                    trs[i].style.display = '';
                    resultFound = true; // At least one result found
                } else {
                    trs[i].style.display = 'none';
                }
            }

            // Show or hide the no results message
            noResults.style.display = resultFound ? 'none' : 'block';
        }
    </script>

</body>
</html>
