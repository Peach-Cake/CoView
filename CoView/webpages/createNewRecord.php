<?php
session_start();
header("Access-Control-Allow-Origin: *");
if(isset($_SESSION["LoggedIn"])==false){
  echo "<script type='text/javascript'>window.location.href = 'http://localhost/CoView';</script>";
}
else if($_SESSION["type"]!="Tester"){
  echo "<script type='text/javascript'>alert('You do not have permission to access this page!');</script>";
  if($_SESSION["type"]=="Manager"){
    echo "<script type='text/javascript'>window.location.href = 'http://localhost/CoView/webpages/ManagerMenu.php';</script>";
  }
  if($_SESSION["type"]=="Patient"){
    echo "<script type='text/javascript'>window.location.href = 'http://localhost/CoView/webpages/patient.php';</script>";
  }
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../scripts/CoView.css">
    <title>Create New Record</title>
  </head>
  <body class="settings">
    <header>
      <h1>COVIEW</h1>
      <nav class="AccountMenu">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php
              echo $_SESSION["LoggedIn"];
            ?>
          </a>

          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <div class="aligning">
              <div class="dropdown-header">Position: Tester</div>
              <div class="dropdown-header"></div>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="http://localhost/CoView/scripts/logout.php">Logout</a>
              </div>
          </div>
      </nav>
    </header>

      <div class="form-container">
          <form id="form" action="" name="recordForm" method="post">
                <label for="patientName"><b>Patient name: </b></label>
                <br>
                <input type="text" name="patientName" size="50" required>
                <br><br>
                <label for="username"><b>Username: </b></label>
                <br>
                <input type="text" name="username" size="50" required>
                <br><br>
                <label for="email"><b>Email: </b></label>
                <br>
                <input type="email" name="email" size="50" required>
                <br><br>
                <label for="password"><b>Password: </b></label>
                <br>
                <input type="password" name="password" size="50" required>
                <br><br>
                <label for="patientType"><b>Patient type:</b></label>
                <select name="patientType">
                  <option value="Infected" name="infected">Infected</option>
                  <option value="Returnee" name="returnee">Returnee</option>
                  <option value="Close Contact" name="closeContact">Close contact</option>
                  <option value="Quarantined" name="quarantined">Quarantined</option>
                  <option value="Suspected" name="suspected">Suspected</option>
                </select><br><br>
                <label for="symptoms"><b>Symptoms: </b></label>
                <br>
                <input type="text" name="symptoms" size="50" required>
                <br><br>
                <label for="testDate"><b>Test date: </b></label>
                <input type="date" name="testDate" size="30" required>
                <br><br>
                <label for="tkeName"><b>Test Kit Name: </b></label>
                <select name="id"  required>
                  <?php
                    $conn = new mysqli("localhost", "root", "", "CoViewDB");
                    $sql = "SELECT * FROM testkit ORDER BY KitID;";
                    $result = $conn->query($sql);
                    if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                      echo "<option value=".$row["KitID"].">".$row["KitID"]." - ". $row["TestKitName"]."</option>";
                    }}
                    $conn->close();
                   ?>
                </select>
                <br><br><br>
                <div class="buttons">
                  <button class="SDBtn" type="button"><a href="testerMenu.php" style="color: white;">Delete</a></button>
                  <button class="SDBtn" name="submit" type="submit" onclick="" style="color: white;">Save</button>

                </div>
              </form>
            </div>


            <div class="btn-container">
            <a href=""><button class="sideBtns">Create report</button></a>
            </div>

            <div class="btn-container">
            <a href="http://localhost/CoView/webpages/testerMenu.php"><button class="sideBtns">View report table</button></a>
            </div>

            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script type="text/javascript" src="../scripts/CoViewJS.js">
            </script>
            <script type="text/javascript">
            reportCreated();
            </script>

</html>
