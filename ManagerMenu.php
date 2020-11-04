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
    <title>Manager Menu</title>
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
    <nav aria-label="breadcrumb" class="navBreadCrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Home</li>
      </ol>
    </nav>
    <div class="container">
      <div class="row">

        <div class="col-md" id="ManagerMenuItems">
          <div class="card">
            <a href="http://localhost/GenerateTestReport.php">
            <img class="card-img-top" src="reportIcon.png" alt="ViewTestReports">
            <div class="card-body">
              <h5 class="card-title">Generate Test Reports</h5>
              <p class="card-text">View the Test Reports done at the test centre.</p>
            </div>
            </a>
          </div>
        </div>

        <div class="col-md" id="ManagerMenuItems">
          <div class="card">
            <a href="http://localhost/ManageTestCentre.php">
            <img class="card-img-top" src="testCentreIcon.png" alt="ManageTestCentre">
            <div class="card-body">
              <h5 class="card-title">Manage Test Centre</h5>
              <p class="card-text">Register Newly approved Testing Centres.</p>
            </div>
            </a>
          </div>
        </div>

        <div class="col-md"  id="ManagerMenuItems">
            <div class="card">
              <a href="http://localhost/TesterTable.php">
              <img class="card-img-top" src="testerIcon.png" alt="RegisterTester">
              <div class="card-body">
                <h5 class="card-title">Register Tester</h5>
                <p class="card-text">Register Newly Joined Testers.</p>
              </div>
              </a>
            </div>
        </div>

        <div class="col-md"  id="ManagerMenuItems">
            <div class="card">
              <a href="http://localhost/ManageTestKitStock.php">
              <img class="card-img-top" src="testKitIcon.png" alt="ManageTestKitStock">
              <div class="card-body">
                <h5 class="card-title">Manage Test Kit Stock</h5>
                <p class="card-text">Add newly arrived test kit stock to the system.</p>
              </div>
              </a>
            </div>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>
