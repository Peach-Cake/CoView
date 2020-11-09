<?php
session_start();
header("Access-Control-Allow-Origin: *");
//$cookieParams = session_get_cookie_params();
//$cookieParams['secure'] = true;
//echo $cookieParams['secure'];
//exit;
//session_set_cookie_params($cookieParams);
//session_start();
//header('Content-type: application/json');
//this is temp as we try to make php work without redirect
//$username = $_PHP['email'];
//$password= $_PHP['password'];
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
          echo "Manager";
          exit;
      }else {
          $_SESSION["TestCentreID"] = '0';
          $_SESSION["LoggedIn"] = $user;
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
      echo "Tester";
      exit;
    }
  }
  if($row["UserType"]=="Patient"){
    header("Location: patient.php");
}
else{
  echo "Not Found";
}
}}else{
  echo "Not Found";
}
$conn->close();
?>
