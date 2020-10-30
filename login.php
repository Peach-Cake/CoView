<?php
//header("Access-Control-Allow-Origin: *");
//this is temp as we try to make php work without redirect
$username = $_POST["email"];
$password= $_POST["password"];
$conn = new mysqli("localhost", "root", "", "CoViewDB");
$sql = "SELECT ID, Username, Password, Email, UserType FROM user
WHERE (Username = '$username' OR Email = '$username') AND Password = '$password';";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $id = $row["ID"];
  if($row["UserType"]=="Officer"){
    $sql2 = "SELECT Position FROM officer
    WHERE UserId = '$id'";
    $result2 = $conn->query($sql2);
    $row2 = mysqli_fetch_assoc($result2);
    if($row2["Position"]=="Tester"){
      header("Location: testerMenu.html");
    }
    if($row2["Position"]=="Manager"){
      header("Location: ManagerMenu.html");
    }
  }
  if($row["UserType"]=="Patient"){
    header("Location: patient.html");
  }
}
else{
  header("Location: index.html");
}
$conn->close();
 ?>
