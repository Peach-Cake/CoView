<?php
session_start();
header("Access-Control-Allow-Origin: *");
$conn = new mysqli("localhost", "root", "", "CoViewDB");
//$testDateFrom = $_POST['testDateFrom'];
//$testDateTo = $_POST['testDateTo'];
//$resultDateFrom = $_POST['resultDateFrom'];
//$resultDateTo = $_POST['resultDateTo'];
$status = $_POST['status'];
//$filters;

//$centreID = $_SESSION['TestCentreID'];
$sql = "CREATE OR REPLACE VIEW reports AS SELECT covidtest.TestID,user.Name,patient.PatientType,DATE_FORMAT(covidtest.TestDate, '%d/%m/%Y') AS TestDate,DATE_FORMAT(covidtest.ResultDate, '%d/%m/%Y') AS ResultDate,covidtest.Status
FROM ((covidtest INNER JOIN user ON covidtest.PatientUserID = user.ID)
INNER JOIN patient ON covidtest.PatientUserID = patient.UserID)";
if(isset($_SESSION['TestCentreID'])){
if($_SESSION["type"]!="Patient"){
  $centreID = $_SESSION['TestCentreID'];
  $sql .= " WHERE covidtest.TestCentreID ='$centreID'";
}}
if(isset($_SESSION['UserID'])){
if ($_SESSION["type"]=="Patient") {
  $id = $_SESSION['UserID'];
  $sql .= " WHERE covidtest.PatientUserID = '$id'";
}}
if(isset($_POST['patientStatus'])){
  $type = $_POST['patientStatus'];
  $sql .= " AND ";
  $sql .= "(";
  for ($i=0; $i < sizeOf($type); $i++) {
    $sql .="patient.PatientType = '$type[$i]'";
    if($i != sizeOf($type)-1){
      $sql .= " OR ";
    }
  }
  $sql .= ")";
}
if($_POST['testDateFrom']!=null||$_POST['testDateTo']!=null){
  if($_POST['testDateTo']==null){
    $testDateFrom = $_POST['testDateFrom'];
    $sql .= " AND covidtest.TestDate >= '$testDateFrom'";
  }
  else if($_POST['testDateFrom']==null){
    $testDateTo = $_POST['testDateTo'];
    $sql .= " AND covidtest.TestDate <= '$testDateTo'";
  }
  else {
    $testDateFrom = $_POST['testDateFrom'];
    $testDateTo = $_POST['testDateTo'];
    $sql .= " AND covidtest.TestDate BETWEEN '$testDateFrom'";
    $sql .= " AND '$testDateTo'";
  }
}
if($_POST['resultDateFrom']!=null||$_POST['resultDateTo']!=null){
  if($_POST['resultDateTo']==null){
    $testDateFrom = $_POST['resultDateFrom'];
    $sql .= " AND covidtest.TestDate >= '$testDateFrom'";
  }
  else if($_POST['resultDateFrom']==null){
    $testDateTo = $_POST['resultDateTo'];
    $sql .= " AND covidtest.TestDate <= '$testDateTo'";
  }
  else {
    $testDateFrom = $_POST['testDateFrom'];
    $testDateTo = $_POST['testDateTo'];
    $sql .= " AND covidtest.TestDate BETWEEN '$testDateFrom'";
    $sql .= " AND '$testDateTo'";
  }
}
if($status != "both"){
  $sql .= " AND covidTest.status = '$status'";
}
$sql .= ";";
$result1 = $conn->query($sql);
$sql2 = "SELECT * FROM reports;";
$result = $conn->query($sql2);
//echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
if (mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
  if($_SESSION["type"]!="Tester"){
  echo "<tr data-toggle='modal' data-target='#resultsModal'>";}
  else{echo "<tr>";}
  echo "<td>T".$row['TestID']."</td>";
  echo "<td>".$row['Name']."</td>";
  echo "<td>".$row['PatientType']."</td>";
  echo "<td>".$row['TestDate']."</td>";
  echo "<td>".$row['ResultDate']."</td>";
  echo "<td>".$row['Status']."</td>";
  if($_SESSION["type"]=="Tester"){
    echo "<td><button data-toggle='modal' data-target='#updateModal'
    style='border: none; background-color: lightblue;'>Update</button></td>";
  }
  echo "</tr>";
}}
$conn->close();
 ?>
