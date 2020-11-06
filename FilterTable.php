<?php
session_start();
header("Access-Control-Allow-Origin: *");
$conn = new mysqli("localhost", "root", "", "CoViewDB");
$testDateFrom = $_POST['testDateFrom'];
$testDateTo = $_POST['testDateTo'];
$resultDateFrom = $_POST['resultDateFrom'];
$resultDateTo = $_POST['resultDateTo'];
$status = $_POST['status'];
//$filters;

$centreID = $_SESSION['TestCentreID'];
$sql = "SELECT covidtest.TestID,user.Name,patient.PatientType,covidtest.TestDate,covidtest.ResultDate,covidtest.Status
FROM ((covidtest INNER JOIN user ON covidtest.PatientUserID = user.ID)
INNER JOIN patient ON covidtest.PatientUserID = patient.UserID) WHERE covidtest.TestCentreID='$centreID' ";
if(isset($_POST['patientStatus'])){
  $type = $_POST['patientStatus'];
$sql .= "AND";
$sql .= "(";
for ($i=0; $i < sizeOf($type); $i++) {
  $sql .="patient.PatientType = '$type[$i]'";
  if($i != sizeOf($type)-1){
    $sql .= " OR ";
  }
}
$sql .= ")";}
$result = $conn->query($sql);
//echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
if (mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>".$row['TestID']."</td>";
  echo "<td>".$row['Name']."</td>";
  echo "<td>".$row['PatientType']."</td>";
  echo "<td>".$row['TestDate']."</td>";
  echo "<td>".$row['ResultDate']."</td>";
  echo "<td>".$row['Status']."</td>";
  echo "</tr>";
}}
$conn->close();
 ?>
