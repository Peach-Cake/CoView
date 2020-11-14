<?php
session_start();
header("Access-Control-Allow-Origin: *");

$tID = $_POST['tid'];

$conn = new mysqli("localhost", "root", "", "CoViewDB");
$sql = "SELECT covidtest.OfficerUserID,covidtest.PatientUserID,covidtest.Result,
patient.Symptoms,testkit.TestKitName,testcentre.CentreName
FROM (((covidtest INNER JOIN testkit ON covidtest.TestKitID = testkit.KitID)
INNER JOIN testcentre ON covidtest.TestCentreID = testcentre.CentreID)
INNER JOIN patient ON covidtest.PatientUserID = patient.UserID)
WHERE TestID = '$tID';";
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $testerID = $row['OfficerUserID'];
  $patientID = $row['PatientUserID'];
  $result = $row['Result'];
  $symptoms = $row['Symptoms'];
  $tkName = $row['TestKitName'];
  $tcName = $row['CentreName'];
}
$sqlUser = "SELECT Username, Name, UserType FROM user
WHERE ID = '$testerID' OR ID='$patientID';";
$resultUser = $conn->query($sqlUser);
if (mysqli_num_rows($resultUser) > 0) {
  while($rowUser = mysqli_fetch_assoc($resultUser)) {
    if($rowUser['UserType']=='Officer'){
      $testerUsername = $rowUser['Username'];
      $testerName = $rowUser['Name'];
    }
    if($rowUser['UserType']=='Patient'){
      $patientUsername = $rowUser['Username'];
      $patientName = $rowUser['Name'];
    }
  }}
  echo "Patient Username: $patientUsername<br>
  Patient Name: $patientName<br>
  Tester Username: $testerUsername<br>
  Tester Name: $testerName<br>
  Test Kit used: $tkName<br>
  Test Administred at: $tcName<br><br>
  Patient Symptoms: $symptoms<br>
  Test Results: $result";
$conn->close();
 ?>
