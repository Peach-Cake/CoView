<?php
session_start();
$conn = new mysqli("localhost", "root", "", "CoViewDB");
$reportResults = $_POST['reportResults'];
$reportID = $_SESSION['tid'];
$resultDate = $_POST['resultDate'];

$sql = "UPDATE covidTest
SET Result = '$reportResults', ResultDate = '$resultDate', Status = 'Complete'
WHERE TestID = '$reportID';";
if ($conn->query($sql) === TRUE) {
  echo "Update";
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();
 ?>
