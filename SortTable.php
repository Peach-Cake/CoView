<?php
session_start();
header("Access-Control-Allow-Origin: *");
$sortby = $_POST['sort'];
$dir = $_POST['dir'];
$conn = new mysqli("localhost", "root", "", "CoViewDB");
if($sortby != 'TestDate' && $sortby != 'ResultDate'){
$sql = "SELECT * FROM reports ORDER BY $sortby $dir;";
}
else {
  $sql = "SELECT TestID,Name,PatientType, TestDate,ResultDate,Status
  FROM reports ORDER BY CONCAT(SUBSTRING($sortby,7,4),'/',
  SUBSTRING($sortby,4,2),'/',SUBSTRING($sortby,1,2)) $dir;";
}
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
  echo "<tr data-toggle='modal' data-target='#resultsModal'>";
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
