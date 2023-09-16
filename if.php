<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Establish database connection
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "collage";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Get form data
  $username = $_POST['username'];
  $password = $_POST['password'];
  $accountType = $_POST['account-type'];

  // Perform login validation against database
  if ($accountType === "teacher") {
    $sql = "SELECT * FROM teachers WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // Login successful for teacher
      header("Location: teacher2.html");
      exit();
    } else {
      // Login failed for teacher
      echo "Invalid username or password for teacher. Please try again.";
    }
  } else {
    $sql = "SELECT * FROM creataccount WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // Login successful for student
      $studentData = $result->fetch_assoc(); // Retrieve student data from the result set
      
      // Close the database connection
      $conn->close();
      
      // Assign student data to variables
      $firstname = $studentData['firstname'];
      $middlename = $studentData['middlename'];
      $lastname = $studentData['lastname'];
      $branch = $studentData['branch'];
      $semester = $studentData['semester'];
      $rollno = $studentData['rollno'];
      
      // Prepare the URL parameters
      $urlParams = "firstname=" . urlencode($firstname) . "&middlename=" . urlencode($middlename) . "&lastname=" . urlencode($lastname) . "&branch=" . urlencode($branch) . "&semester=" . urlencode($semester) . "&rollno=" . urlencode($rollno);
      
      // Redirect to student.php with URL parameters
      header("Location: student.php?$urlParams");
      exit();
    } else {
      // Login failed for student
      echo "Invalid username or password for student. Please try again.";
    }
  }

  $conn->close();
}
?>
