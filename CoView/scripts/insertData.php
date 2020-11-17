<?php
session_start();
header("Access-Control-Allow-Origin: *");

$conn = new mysqli("localhost", "root", "", "CoViewDB");
$patientName = $_POST['patientName'];
$tester = $_SESSION["LoggedIn"];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$patientType = $_POST['patientType'];
$symptoms = $_POST['symptoms'];
$testDate = $_POST['testDate'];
$testKitID = $_POST['id'];
$centreID = $_SESSION['TestCentreID'];
$passwordHash = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO User(Username, Password, Name, Email, UserType)
VALUES ('$username', '$passwordHash', '$patientName', '$email', 'Patient')";
if ($conn->query($sql) == true){
//  echo "Added";
}else{
  echo "Failed" . $conn->error . "<br>";
}

$last_id = $conn->insert_id;
$sql = "INSERT INTO Patient(UserID, PatientType, Symptoms)
VALUES ('$last_id', '$patientType', '$symptoms')";
if ($conn->query($sql) == true){
  //echo "Added";
}else{
  echo "Failed" . $conn->error . "<br>";
}

$id = "SELECT ID FROM User WHERE Username = '$tester';";
$result = $conn->query($id);
if (mysqli_num_rows($result) > 0) {
  $rowget = mysqli_fetch_assoc($result);
  $testerID = $rowget["ID"];
}


$updateStock = "UPDATE TestCentreKitStock
SET AvailableStock = AvailableStock -1
WHERE TestKitID = '$testKitID';";
$stock = $conn->query($updateStock);
  if ($stock == true) {
  //echo "Stock updated!" . $stock;
}else{
  echo "Failed" . $conn->error . "<br>";
}

$insertData = "INSERT INTO CovidTest(
  OfficerUserID, PatientUserID,
  TestDate, TestKitID, TestCentreID)
  VALUES ('$testerID', '$last_id', '$testDate', '$testKitID', '$centreID')";
if ($conn->query($insertData) == true){
  //echo "Added";
}else{
  echo "Failed" . $conn->error . "<br>";
}

$query = "SELECT *
FROM TestCentreKitStock
WHERE TestCentreID = '$centreID' AND TestKitID = '$testKitID';";
$stock = $conn->query($query);
if (mysqli_num_rows($stock) > 0){
  $row = mysqli_fetch_assoc($stock);
  $numStock = $row['AvailableStock'];
  if ($numStock > 0){
      echo "Added";
  }else{
  echo "Failed";
  exit;
}
}
$conn->close();
 ?>
