<?php
session_start();
header("Access-Control-Allow-Origin: *");

$name = $_POST["tName"];
$username = $_POST["tUsername"];
$email = $_POST["tEmail"];
$password = $_POST["tPassword"];
$cnpassword = $_POST["tCnPassword"];

$conn = new mysqli("localhost", "root", "", "CoViewDB");
$sql = "SELECT Username, Email FROM User
WHERE Username = '$username' OR Email = '$email';";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    if($row['Username']==$username){
      echo "Username";
      exit;
    }
    if($row['Email']==$email){
      echo "Email";
      exit;
    }
  }
}
else{
  $testcentre = $_SESSION["TestCentreID"];
  $sqlUser = "INSERT INTO User(Username, Password, Name, Email, UserType)
  VALUES ('$username', '$password', '$name', '$email', 'Officer');";
  $conn->query($sqlUser);
  $last_id = $conn->insert_id;
  $sqlTester = "INSERT INTO Officer(UserID, Position, RegisteredCentreID)
  VALUES ('$last_id', 'Tester', '$testcentre');";
  $conn->query($sqlTester);
  echo "Added";
}
$conn->close();
 ?>
