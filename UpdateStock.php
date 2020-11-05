<?php
session_start();
header("Access-Control-Allow-Origin: *");

$centreID = $_SESSION['TestCentreID'];
$tkID = $_POST['tkeName'];
$addStock = $_POST['tkeStock'];
$conn = new mysqli("localhost", "root", "", "CoViewDB");
$sql = "UPDATE testcentrekitstock SET AvailableStock = AvailableStock + '$addStock'
WHERE TestCentreID = '$centreID' AND TestKitID = '$tkID';";
if ($conn->query($sql) === TRUE) {
  echo "Update";
} else {
  echo "Error updating record: " . $conn->error;
}
$conn->close();
 ?>
