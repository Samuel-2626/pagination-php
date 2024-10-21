<?php

require_once("connect.php"); // Connect to the database

// Handle form submission to add a new student
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $name = $_POST['name'];
    $school = $_POST['school'];

    // Validate inputs (basic validation, can be expanded)
    if (!empty($name) && !empty($school)) {
        // Prepare the SQL insert statement
        $stmt = $conn->prepare("INSERT INTO students (name, school) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $school);

        // Execute the statement
        if ($stmt->execute()) {
            $success_message = "Student added successfully!";
        } else {
            $error_message = "Error: Could not add the student.";
        }

        // Close the statement
        $stmt->close();
    } else {
        $error_message = "Please fill in both the Name and School fields.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Student</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Add New Student</h2>

    <?php
    if (isset($success_message)) {
        echo '<div class="alert alert-success" role="alert">' . $success_message . '</div>';
    }
    if (isset($error_message)) {
        echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
    }
    ?>

    <!-- Form to add a new student -->
    <form action="add_student.php" method="POST" class="form-horizontal">
        <div class="form-group mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter student's name">
        </div>

        <div class="form-group mb-3">
            <label for="school" class="form-label">School</label>
            <input type="text" name="school" class="form-control" id="school" placeholder="Enter student's school">
        </div>

        <button type="submit" class="btn btn-primary">Add Student</button>
    </form>

    <div class="mt-3">
        <a href="index.php" class="btn btn-secondary">View All Students</a>
    </div>
</div>

<!-- Include Bootstrap JS for responsive behaviors -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
