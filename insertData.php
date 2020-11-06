<?php
session_start();
header("Access-Control-Allow-Origin: *");
If(isset($_POST['submit'])) {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
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

$sql = "INSERT INTO User(Username, Password, Name, Email, UserType)
VALUES ('$username', '$password', '$patientName', '$email', 'Patient')";
if ($conn->query($sql) == true){
  echo "Added successfully";
}else{
  echo "Failed" . $conn->error . "<br>";
}

$last_id = $conn->insert_id;
$sql = "INSERT INTO Patient(UserID, PatientType, Symptoms)
VALUES ('$last_id', '$patientType', '$symptoms')";
if ($conn->query($sql) == true){
  echo "Added successfully";
}else{
  echo "Failed" . $conn->error . "<br>";
}

$id = "SELECT ID FROM User WHERE Username = '$tester';";
$result = $conn->query($id);
if (mysqli_num_rows($result) > 0) {
  $rowget = mysqli_fetch_assoc($result);
  $testerID = $rowget["ID"];
}

/*$updateStock = "UPDATE TestCentreKitStock
SET AvailableStock = AvailableStock -1
WHERE TestKitID = '$testKitID';";
$result = $conn->query($updateStock);
if ($result == true) {
  echo "Stock updated!" . $result;
}else{
  echo "Failed" . $conn->error . "<br>";
}
*/
$insertData = "INSERT INTO CovidTest(
  OfficerUserID, PatientUserID,
  TestDate, TestKitID, TestCentreID)
  VALUES ('$testerID', '$last_id', $testDate, '$testKitID', '$centreID')";
if ($conn->query($insertData) == true){
  echo "Added successfully";
}else{
  echo "Failed" . $conn->error . "<br>";
}

if ($username != ''){
  header("Location: http://localhost/testerMenu.php");
}
}
$conn->close();
}



 ?>
