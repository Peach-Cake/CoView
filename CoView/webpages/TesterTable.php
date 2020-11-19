<?php
session_start();
header("Access-Control-Allow-Origin: *");
if(isset($_SESSION["LoggedIn"])==false){
  echo "<script type='text/javascript'>window.location.href = 'http://localhost/CoView';</script>";
}
else if($_SESSION["type"]!="Manager"){
  echo "<script type='text/javascript'>alert('You do not have permission to access this page!');</script>";
  if($_SESSION["type"]=="Tester"){
    echo "<script type='text/javascript'>window.location.href = 'http://localhost/CoView/webpages/testerMenu.php';</script>";
  }
  if($_SESSION["type"]=="Patient"){
    echo "<script type='text/javascript'>window.location.href = 'http://localhost/CoView/webpages/patient.php';</script>";
  }
}
if($_SESSION["TestCentreID"]=='0'){
  echo "<script type='text/javascript'>alert('You need to register Test Centre First!');";
  echo "window.location.href = 'http://localhost/CoView/webpages/ManageTestCentre.php';</script>";
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8"></meta>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"></meta>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"></link>
    <link rel="stylesheet" type="text/css" href="../scripts/CoView.css"></link>

    <title>Register Tester</title>
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
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="http://localhost/CoView/scripts/logout.php">Log out</a>
        </div>
      </div>
      </nav>
    </header>

  <main>
      <nav aria-label="breadcrumb" class="navBreadCrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item" aria-current="page"><a href="http://localhost/CoView/webpages/ManagerMenu.php">Home</a></li>
          <li class="breadcrumb-item" aria-current="page">Register Tester</li>
        </ol>
      </nav>

          <!--<div class="search-container">
            Search:  <input type="text" placeholder="Tester" name="search">
          <button id="viewBtn" type="button" onclick="search()">View</button>
        </div>-->

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Register Tester</h5>
                <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="testerForm" name="tForm" method="post" action="">
                  <label for="tName">Tester Name: </label>
                  <br>
                  <input type="text" name="tName" id="tName" size="50" required></input>
                  <br><small class="errorNotifications"></small><br>
                  <label for="tUsername">Tester Username: </label>
                  <br>
                  <input type="text" name="tUsername" id="tUsername"size="50" required></input>
                  <br><small class="errorNotifications"></small><br>
                  <label for="tEmail">Tester Email: </label>
                  <br>
                  <input type="email" name="tEmail" id="tEmail" size="50" required></input>
                  <br><br>
                  <label for="tPassword">Password: </label>
                  <br>
                  <input type="password" name="tPassword" id="tPassword" size="50" required></input>
                  <br><small class="errorNotifications"></small><br>
                  <label for="tCnPassword">Confirm Password: </label>
                  <br>
                  <input type="password" name="tCnPassword" id="tCnPassword" size="50" required></input>
                  <br><br><br>

              <div class="modal-footer">
                <div class="buttons">
                  <button type="submit" class="SDBtn">Save</button>
                </div>
              </div>
            </form>
          </div>
            </div>
          </div>
        </div>
        <div class="report-container">
        <table id="tester-table" class="table">
          <thead>
          <tr>
            <th>Username</th>
            <th>Tester name</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $tcID = $_SESSION['TestCentreID'];
          $conn = new mysqli("localhost", "root", "", "CoViewDB");
          $sql = "SELECT Username, Name , Email FROM user
          WHERE ID in (SELECT UserID FROM officer WHERE RegisteredCentreID='$tcID' AND Position = 'Tester')";
          $result = $conn->query($sql);
          if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["Username"]. "</td>";
            echo "<td>" . $row["Name"]. "</td> ";
            echo "<td>" . $row["Email"]. "</td>";
            echo "</tr>";
          }}//else{echo "test";}
          $conn->close();
           ?>
        </tbody>
        </table>
      </div>
      <div class="btn-container" style="margin-left: 15%; padding-top:5px">
        <button type="button"  id="addBtn" data-toggle="modal" data-target="#exampleModalCenter">
          <img src="../icons/plus.png" alt="register tester" style="width: 25px; padding-right: 2px;">Register Tester
        </button>
      </div>

      </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../scripts/CoViewJS.js">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">
      registerTester();
    </script>
  </body>
</main>
</html>
