<!DOCTYPE html>
<html lang="en">
<head>
    <title>Grade Entry Tool</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 500px; margin: 0 auto; padding: 20px; }
        h1 { text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; }
        input[type="number"] { width: 100%; padding: 8px; }
        button { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer; width: 100%; }
        button:hover { background-color: #45a049; }
    </style>
</head>
<body>
<div class="container">
    <h1>Enter Grades for Students</h1>
    <form method="POST">
        <label for="student_id">Select Student:</label>
        <select id="student_id" name="student_id" required>
            <?php
            // Database connection
            $conn = new mysqli("localhost", "csc350", "xampp", "grading_system");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve students' information
            $result = $conn->query("SELECT student_id, first_name, last_name FROM students");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['student_id']}'>{$row['student_id']} - {$row['first_name']} {$row['last_name']}</option>";
            }
            ?>
        </select>

        <h3>Homework Grades</h3>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <div class="form-group">
                <label for="homework<?= $i ?>">Homework <?= $i ?>:</label>
                <input type="number" id="homework<?= $i ?>" name="homework[]" min="0" max="100" required>
            </div>
        <?php endfor; ?>

        <h3>Quiz Grades</h3>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <div class="form-group">
                <label for="quiz<?= $i ?>">Quiz <?= $i ?>:</label>
                <input type="number" id="quiz<?= $i ?>" name="quiz[]" min="0" max="100" required>
            </div>
        <?php endfor; ?>

        <div class="form-group">
            <label for="midterm">Midterm:</label>
            <input type="number" id="midterm" name="midterm" min="0" max="100" required>
        </div>

        <div class="form-group">
            <label for="final_project">Final Project:</label>
            <input type="number" id="final_project" name="final_project" min="0" max="100" required>
        </div>

        <button type="submit" name="submit">Submit Grades</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $student_id = $_POST['student_id'];
        $homework = $_POST['homework'];
        $quiz = $_POST['quiz'];
        $midterm = $_POST['midterm'];
        $final_project = $_POST['final_project'];

        // Calculate average homework score
        $homework_avg = array_sum($homework) / count($homework) * 0.2;

        // Drop the lowest quiz score and calculate average
        sort($quiz);
        array_shift($quiz); // Remove the lowest score
        $quiz_avg = array_sum($quiz) / count($quiz) * 0.1;

        // Calculate weighted scores
        $midterm_score = $midterm * 0.3;
        $final_project_score = $final_project * 0.4;

        // Calculate final grade
        $final_grade = round($homework_avg + $quiz_avg + $midterm_score + $final_project_score);
        // ... (rest of the code)

$insert_final_grade_sql = "INSERT INTO final_grades (student_id, final_grade) 
VALUES ('$student_id', '$final_grade')";


        // Database insertions
        $insert_homework_sql = "INSERT INTO homework (student_id, homework1, homework2, homework3, homework4, homework5) 
                                VALUES ('$student_id', '{$homework[0]}', '{$homework[1]}', '{$homework[2]}', '{$homework[3]}', '{$homework[4]}')";

        $insert_quiz_sql = "INSERT INTO quizzes (student_id, quiz1, quiz2, quiz3, quiz4, quiz5) 
                            VALUES ('$student_id', '{$quiz[0]}', '{$quiz[1]}', '{$quiz[2]}', '{$quiz[3]}', '{$quiz[4]}')";

        $insert_midterm_sql = "INSERT INTO midterm (student_id, midterm_score) 
                               VALUES ('$student_id', '$midterm')";

        $insert_final_project_sql = "INSERT INTO final_project (student_id, final_project_score) 
                                      VALUES ('$student_id', '$final_project')";

        // Execute queries
        if ($conn->query($insert_homework_sql) === TRUE &&
            $conn->query($insert_quiz_sql) === TRUE &&
            $conn->query($insert_midterm_sql) === TRUE &&
            $conn->query($insert_final_project_sql) === TRUE &&
            $conn->query($insert_final_grade_sql) === TRUE){
          // Get student name for display
            $student_info = $conn->query("SELECT first_name, last_name FROM students WHERE student_id = '$student_id'")->fetch_assoc();
            echo "<p>Grades for Student ID {$student_id} ({$student_info['first_name']} {$student_info['last_name']}) recorded successfully. Final Grade: {$final_grade}</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }

        $conn->close();
    }  
    ?>
    
</div>
</body>
</html>                                            