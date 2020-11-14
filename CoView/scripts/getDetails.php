<?php
session_start();
$conn = new mysqli("localhost", "root", "", "CoViewDB");
$testID = $_POST['tid'];
$_SESSION['tid'] = $testID;
$sql = "SELECT patient.Symptoms, user.name, covidTest.result
FROM ((covidtest INNER JOIN User ON covidtest.PatientUserID = User.ID)
INNER JOIN patient on covidTest.PatientUserID = patient.UserID)
WHERE TestID = '$testID';";

$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $symptoms = $row['Symptoms'];
  $patientName = $row['name'];
  $results = $row['result'];
}

echo "<b>Patient name: </b>$patientName <br>
<b>Symptoms: </b>$symptoms <br>
<b>Results: </b>$results";
$conn->close();

 ?>
