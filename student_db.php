 
<?php
 
 require_once("connect.php");
  
  
 $sql = "CREATE TABLE Students (
     id INT AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR(32) NOT NULL,
     school VARCHAR(100) NOT NULL
 )";
  
  
 if ($conn->query($sql)) {
     echo "Students table created successfully <br>";
 } else {
     echo "Error message: <br> $conn->error <br>";
 }
  
  
  
 ?>