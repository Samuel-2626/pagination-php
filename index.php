<?php
 
require_once("connect.php");
 
// Handle form submission to add a new student
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $school = $_POST['school'];
 
    $stmt = $conn->prepare("INSERT INTO students (name, school) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $school);
    $stmt->execute();
    $stmt->close();
}
 
// Pagination logic
$limit = 10; // Records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;
 
// Fetch total number of records
$result_total = $conn->query("SELECT COUNT(*) AS total FROM students");
$row_total = $result_total->fetch_assoc();
$total_records = $row_total['total'];
$total_pages = ceil($total_records / $limit);
 
// Fetch records with limit and offset
$query = "SELECT * FROM students LIMIT $limit OFFSET $offset";
$result = $conn->query($query);
 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <style>
 
        /* Apply colors to the pagination */
        .pagination .page-item.active .page-link {
            background-color: #004C97;
            color: lightgrey;
        }
        .pagination .page-link {
            color: #323232 ;
        }
 
    </style>
 
</head>
<body>
 
<div class="container">
 
<br>
 
<h1 class="text-center">Student Records</h1>
<br>
<table class="table table-bordered table-striped">
<style>
th, td,tr {
border: 2px solid black;
}
</style>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>School</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"]. "</td><td>" . $row["name"]. "</td><td>" . $row["school"]. "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No records found</td></tr>";
    }
    ?>
</table>
 
<?php
// To not show pagination for records < 11
if ($total_records > $limit) {
   
?>
 
<!-- Pagination -->
 
    <ul class="pagination justify-content-center">
        <?php
        // Number of links to show on either side of the current page
        $adjacents = 1;
 
        // "Previous" button
        if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page - 1 ?>"><<
                </a>
            </li>
        <?php endif;
 
        // Show the first page and a "..." if necessary
        if ($page == ($adjacents+2)): ?>
            <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
        <?php
       
       elseif ($page > ($adjacents + 1)): ?>
            <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
            <li class="page-item disabled"><span class="page-link">...</span></li>
        <?php endif;
 
        // Page number links around the current page
        $start = max(1, $page - $adjacents);
        $end = min($total_pages, $page + $adjacents);
 
        for ($i = $start; $i <= $end; $i++):
            if ($i == $page): ?>
                <li class="page-item active" aria-current="page">
                    <span class="page-link"><?= $i ?></span>
                </li>
            <?php else: ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
            <?php endif;
        endfor;
 
        // Show "..." after current page links if necessary
        if ($page == ($total_pages - $adjacents - 1)): ?>
            <li class="page-item"><a class="page-link" href="?page=<?= $total_pages ?>"><?= $total_pages?></a></li>
        <?php
       
        elseif ($page < ($total_pages - $adjacents)): ?>
            <li class="page-item disabled"><span class="page-link">...</span></li>
            <li class="page-item"><a class="page-link" href="?page=<?= $total_pages ?>"><?= $total_pages?></a></li>
        <?php endif;
 
        // "Next" button
        if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page + 1 ?>">>>
                </a>
            </li>
        <?php endif; ?>
 
    </ul>
    <?php
 
        }
 
        ?>
<br>
    <div class = "pagination justify-content-center">
            <a href="add_student.php" class="btn btn-primary">Add a new student</a>
        </div>
 
</div>
 
<br>
<br>
 
 
 
<!-- Include Bootstrap JS for responsive behaviors -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
 
</body>
</html>