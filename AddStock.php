<?php
session_start();
header("Access-Control-Allow-Origin: *");
$tkName = $_POST['tknName'];
$tkStock = $_POST['tknStock'];
$centreID = $_SESSION['TestCentreID'];
$conn = new mysqli("localhost", "root", "", "CoViewDB");
$sqlCheck = "SELECT * FROM testkit
WHERE TestKitName = '$tkName';";
$resultCheck = $conn->query($sqlCheck);
if (mysqli_num_rows($resultCheck) > 0) {
  echo "Exists";
  exit;
}
$sql = "INSERT INTO TestKit(TestKitName)
VALUES ('$tkName');";
if ($conn->query($sql) === TRUE) {
  echo "Added";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}
$last_id = $conn->insert_id;
$sqltc = "SELECT CentreID FROM testcentre;";
$resulttc = $conn->query($sqltc);
if (mysqli_num_rows($resulttc) > 0) {
  while($row = mysqli_fetch_assoc($resulttc)) {
    $tcID = $row["CentreID"];
    $sqltk = "INSERT INTO TestCentreKitStock(TestCentreID, TestKitID, AvalaibleStock)
    VALUES ('$tcID','$last_id',0);";
    $conn->query($sqltk);
  }
}
/*$sql2 = "INSERT INTO TestCentreKitStock(TestCentreID, TestKitID, AvalaibleStock)
VALUES ('$centreID','$last_id','$tkStock');";
if ($conn->query($sql2) === TRUE) {
  echo "Added";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}*/
$sql2 = "UPDATE testcentrekitstock SET AvalaibleStock = $tkStock
WHERE TestCentreID = '$centreID' AND TestKitID = '$last_id';";
if ($conn->query($sql2) === TRUE) {
  echo "Added";
} else {
  echo "Error updating record: " . $conn->error;
}
$conn->close();

 ?>
