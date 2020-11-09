<?php
session_start();
header("Access-Control-Allow-Origin: *");
if(isset($_SESSION["LoggedIn"])==false){
  echo "<script type='text/javascript'>window.location.href = 'http://localhost';</script>";
}
if($_SESSION["TestCentreID"]=='0'){
  echo "<script type='text/javascript'>alert('You need to register Test Centre First!');";
  echo "window.location.href = 'http://localhost/ManageTestCentre.php';</script>";
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="CoView.css">
    <title>Update Record</title>
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
              <div class="dropdown-header">Position: Manager</div>
              <div class="dropdown-header"></div>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="http://localhost/logout.php">Logout</a>
              </div>
          </div>
      </nav>
    </header>

  <main>


    <div class="form-container">
        <form id="form" method="post">

              <label for="testerName"><b>Tester: </b></label>
              <br>
              <input type="text" name="testerName" size="50" required>
              <br><br>
              <?php
              echo "<label><b>Patient name:</b> John</label> <br><br>";
              echo "<label><b>Symptoms: </b></label> <br>";
              echo "<input size='50' value='High fever'>
              <br><br>";
               ?>
              <label for="patientType"><b>Patient type:</b></label>
              <select name="patientType">
                <option value="Infected" name="infected">Infected</option>
                <option value="Returnee" name="returnee">Returnee</option>
                <option value="Close Contact" name="closeContact">Close contact</option>
                <option value="Quarantined" name="quarantined">Quarantined</option>
                <option value="Suspected" name="suspected">Suspected</option>
              </select><br><br>

              <label for="testDate"><b>Result date: </b></label>
              <input type="date" name="resultDate" size="30" required>

              <br><br><br>
              <div class="buttons">
                <button class="SDBtn" type="button">Delete</button>
                <button class="SDBtn" name="submit" type="submit" onclick="">Save</button>

              </div>
            </form>
          </div>


    <div class="btn-container">
    <a href="createNewRecord.php"><button class="sideBtns">Create report</button></a>
    </div>

    <div class="btn-container">
    <a href="testerMenu.php"><button class="sideBtns">View report table</button></a>
    </div>

    <div>
      <script type="text/javascript" src="CoViewJS.js"></script>
    </div>
  </main>

  </body>
</html>
