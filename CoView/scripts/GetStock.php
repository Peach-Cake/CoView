<?php
session_start();
header("Access-Control-Allow-Origin: *");

$tkID = $_POST['id'];
$centreID = $_SESSION['TestCentreID'];
$conn = new mysqli("localhost", "root", "", "CoViewDB");
$sql = "SELECT * FROM testcentrekitstock
WHERE TestCentreID = '$centreID' AND TestKitID = '$tkID';";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  echo $row["AvailableStock"];
}
$conn->close();
 ?>
