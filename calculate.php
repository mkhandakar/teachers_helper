<?php
// final_grades.php
$conn = new mysqli("localhost", "csc350", "xampp", "grading_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("
    SELECT s.student_id, s.first_name, s.last_name, fg.final_grade
    FROM students s
    JOIN final_grades fg ON s.student_id = fg.student_id
");

    echo "<h1>Final Grades</h1>";
    echo "<table border='1'>
    <tr>
    <th>Student ID</th>
    <th>Name</th>
    <th>Final Grade</th>
    </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>{$row['student_id']}</td>
        <td>{$row['first_name']} {$row['last_name']}</td>
        <td>{$row['final_grade']}</td>
        </tr>";
    }
    echo "</table>";
 

$conn->close();
?>
