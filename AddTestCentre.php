<?php
session_start();
header("Access-Control-Allow-Origin: *");

$manager = $_SESSION["LoggedIn"];
$tcName = $_POST["tcName"];
$tcAddress1 = $_POST["tcAddress1"];
$tcAddress2 = $_POST["tcAddress2"];
$state = $_POST["state"];
$postcode = $_POST["postcode"];

$conn = new mysqli("localhost", "root", "", "CoViewDB");
$sqlCheck = "SELECT CentreName FROM testcentre
WHERE CentreName = '$tcName';";
$resultCheck = $conn->query($sqlCheck);
if (mysqli_num_rows($resultCheck) > 0) {
  echo "Exists";
  exit;
}
$sqlget = "SELECT ID FROM user WHERE Username = '$manager';";
$resultget = $conn->query($sqlget);
if (mysqli_num_rows($resultget) > 0) {
  $rowget = mysqli_fetch_assoc($resultget);
  $managerID = $rowget["ID"];
}
$sql = "INSERT INTO TestCentre(CentreName,AddressLine1,AddressLine2,State,Postcode)
VALUES ('$tcName','$tcAddress1','$tcAddress2','$state','$postcode');";
if ($conn->query($sql) === TRUE) {
  echo "Added";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
$last_id = $conn->insert_id;
$sqlup = "UPDATE officer SET RegisteredCentreID = '$last_id' WHERE UserID = '$managerID';";
if ($conn->query($sqlup) === TRUE) {
  $_SESSION["TestCentreID"]= $last_id;
  echo "Added";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
$sqltk = "SELECT KitID FROM testkit;";
$resulttk = $conn->query($sqltk);
if (mysqli_num_rows($resulttk) > 0) {
  while($rowtk = mysqli_fetch_assoc($resulttk)) {
    $tkID = $rowtk["KitID"];
    $sqltk = "INSERT INTO TestCentreKitStock(TestCentreID, TestKitID, AvalaibleStock)
    VALUES ('$last_id','$tkID',0);";
    $conn->query($sqltk);
  }
}
$conn->close();
 ?>
