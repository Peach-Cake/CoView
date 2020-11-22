<?php
session_start();
header("Access-Control-Allow-Origin: *");
$params = array();
$username = $_POST["email"];

$conn = new mysqli("localhost", "root", "", "CoViewDB");
$sql = "SELECT ID, Username, Password, Email, UserType FROM user
WHERE (Username = '$username' OR Email = '$username');";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  if(password_verify($_POST["password"], $row["Password"])==true){
  $id = $row["ID"];
  $user = $row["Username"];
  if($row["UserType"]=="Officer"){
    $sql2 = "SELECT Position FROM officer
    WHERE UserId = '$id'";
    $result2 = $conn->query($sql2);
    $row2 = mysqli_fetch_assoc($result2);
    if($row2["Position"]=="Manager"){
      $sqlMan = "SELECT RegisteredCentreID FROM officer
      WHERE UserID = '$id';";
      $resultMan = $conn->query($sqlMan);
      $rowMan = mysqli_fetch_assoc($resultMan);
      if (isset($rowMan["RegisteredCentreID"])) {
          $_SESSION["TestCentreID"] = $rowMan["RegisteredCentreID"];
          $_SESSION["LoggedIn"] = $user;
          $_SESSION["type"] = "Manager";
          echo "Manager";
          exit;
      }else {
          $_SESSION["TestCentreID"] = '0';
          $_SESSION["LoggedIn"] = $user;
          $_SESSION["type"] = "Manager";
          echo "NewManager";
          exit;
      }

      $_SESSION["LoggedIn"] = $user;
      echo "Manager";
    }
    if($row2["Position"]=="Tester"){
      $sqlMan = "SELECT RegisteredCentreID FROM officer
      WHERE UserID = '$id';";
      $resultMan = $conn->query($sqlMan);
      $rowMan = mysqli_fetch_assoc($resultMan);
      $_SESSION["TestCentreID"] = $rowMan["RegisteredCentreID"];
      $_SESSION["LoggedIn"] = $user;
      $_SESSION["type"] = "Tester";
      echo "Tester";
      exit;
    }
  }
  if($row["UserType"]=="Patient"){
    $_SESSION["UserId"] = $id;
    $_SESSION["LoggedIn"] = $user;
    $_SESSION["type"] = "Patient";
    echo "Patient";
    exit;
  }
else{
  echo "Not Found";
}
}
else{
  echo "Not Found";
}}else{
  echo "Not Found";
}
$conn->close();
?>
