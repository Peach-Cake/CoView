<?php
header("Access-Control-Allow-Origin: *");
session_start();
//header('Content-type: application/json');
//this is temp as we try to make php work without redirect
//$username = $_PHP['email'];
//$password= $_PHP['password'];
$params = array();
$username = $_POST["email"];
$password = $_POST["password"];
$conn = new mysqli("localhost", "root", "", "CoViewDB");
$sql = "SELECT ID, Username, Password, Email, UserType FROM user
WHERE (Username = '$username' OR Email = '$username') AND Password = '$password';";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $id = $row["ID"];
  $user = $row["Username"];
  if($row["UserType"]=="Officer"){
    $sql2 = "SELECT Position FROM officer
    WHERE UserId = '$id'";
    $result2 = $conn->query($sql2);
    $row2 = mysqli_fetch_assoc($result2);
    if($row2["Position"]=="Tester"){
      header("Location: testerMenu.html");
    }
    if($row2["Position"]=="Manager"){
      //header("Location: http://localhost/ManagerMenu.php");
      $_SESSION["LoggedIn"] = $user;
      echo "Manager";
      //exit;
    }
  }
  if($row["UserType"]=="Patient"){
    header("Location: patient.html");
  }
}
else{
  echo "Not Found";
}
$conn->close();
 ?>
