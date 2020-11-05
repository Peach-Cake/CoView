<?php
$conn = new mysqli("localhost", "root", "", "CoViewDB");
$patientName = $_POST['patientName'];
$tester = $_SESSION["LoggedIn"];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$patientType = $_POST['patientType'];
$symptoms = $_POST['symptoms'];
$testDate = $_POST['testDate'];
$tkename = $_POST['tkename'];
$centreID = $_SESSION['TestCentreID'];

$sql1 = "INSERT INTO User(Username, Password, Name, Email)
VALUES ('$username', '$password', '$patientName', '$email')";
if ($conn->query($sql1) == true){
  echo "Added successfully";
}else{
  echo "Failed" . $conn->error;
}

$last_id = $conn->insert_id;
$sql2 = "INSERT INTO Patient(UserID, PatientType, Symptoms)
VALUES ('$last_id', '$patientType', '$symptoms')";
if ($conn->query($sql2) == true){
  echo "Added successfully";
}else{
  echo "Failed" . $conn->error;
}

$sql3 = "UPDATE TestCentreKitStock
SET AvailableStock = AvailableStock -1
WHERE TestKitName = $tkename;";
if ($conn->query($sql3) == true) {
  echo "1 kit used";
}
else{
  echo "No more available kits";
}


$sql4 = "SELECT ID FROM User WHERE Username = '$tester';";
$result = $conn->query($sql4);
if (mysqli_num_rows($result) > 0) {
  $rowget = mysqli_fetch_assoc($result);
  $testerID = $rowget["ID"];
}

$last_id = $conn->insert_id;
$sql5 = "INSERT INTO CovidTest(
  OfficerUserID, PatientUserID,
  TestDate, TestKitID, TestCentreID)
  VALUES ('$testerID', '$last_id', $testDate, '$last_id', '$centreID')";
if ($conn->query($sql5) == true){
  echo "Added successfully";
}else{
  echo "Failed" . $conn->error;
}







 ?>
