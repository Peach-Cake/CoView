<?php
session_start();
header("Access-Control-Allow-Origin: *");
if(isset($_SESSION["LoggedIn"])==false){
  echo "<script type='text/javascript'>window.location.href = 'http://localhost/CoView';</script>";
}
else if($_SESSION["type"]!="Patient"){
  echo "<script type='text/javascript'>alert('You do not have permission to access this page!');</script>";
  if($_SESSION["type"]=="Tester"){
    echo "<script type='text/javascript'>window.location.href = 'http://localhost/CoView/webpages/testerMenu.php';</script>";
  }
  if($_SESSION["type"]=="Manager"){
    echo "<script type='text/javascript'>window.location.href = 'http://localhost/CoView/webpages/ManagerMenu.php';</script>";
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
    <script src="CoViewJS.js"></script>
    <title>Patient Menu</title>
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
          <div class="dropdown-header">Position: Patient</div>
          <a class="dropdown-item" href="#"></a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="http://localhost/CoView/scripts/logout.php">Logout</a>
        </div>
      </nav>
    </header>

    <main>
    <nav aria-label="breadcrumb" class="navBreadCrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">Home</li>
      </ol>
    </nav>



      <div class="report-container">
        <table style="text-align: center;" class="table">
          <thead>
          <tr>
            <th id="TestID" data-dir="ASC">Test ID <img src=../icons/ascTableSorter.png class="tableSortPointers"></img></th>
            <th id="Name" data-dir="NONE">Patient name <img src=../icons/doubleTableSorter.png class="tableSortPointers"></img></th>
            <th id="PatientType" data-dir="NONE">Patient type <img src=../icons/doubleTableSorter.png class="tableSortPointers"></img></th>
            <th id="TestDate" data-dir="NONE">Test date <img src=../icons/doubleTableSorter.png class="tableSortPointers"></img></th>
            <th id="ResultDate" data-dir="NONE">Result date <img src=../icons/doubleTableSorter.png class="tableSortPointers"></img></th>
            <th id="Status" data-dir="NONE">Status <img src=../icons/doubleTableSorter.png class="tableSortPointers"></img></th>
          </tr>
          <?php
          $conn = new mysqli("localhost", "root", "", "CoViewDB");
          //$query = "SELECT * FROM ReportTable";
          //$result = $conn->query($query);
          echo "<tbody>";
          $currentId = $_SESSION['UserId'];
          $login = $_SESSION['LoggedIn'];
          $sql = "CREATE OR REPLACE VIEW reports AS SELECT covidtest.TestID,user.Name,patient.PatientType,DATE_FORMAT(covidtest.TestDate, '%d/%m/%Y') AS TestDate,DATE_FORMAT(covidtest.ResultDate, '%d/%m/%Y') AS ResultDate,covidtest.Status
          FROM ((covidtest INNER JOIN user ON covidtest.PatientUserID = user.ID)
          INNER JOIN patient ON covidtest.PatientUserID = patient.UserID) WHERE covidtest.PatientUserID = '$currentId';";
          $result1 = $conn->query($sql);
          $sql2 = "SELECT * FROM reports;";
          $result = $conn->query($sql2);
          //echo "Error: " . $sql1 . "<br>" . $conn->error . "<br>";
          if (mysqli_num_rows($result) > 0) {

          while($row = mysqli_fetch_assoc($result)) {

            echo "<tr data-toggle='modal' data-target='#resultsModal'>";
            echo "<td>T".$row['TestID']."</td>";
            echo "<td>".$row['Name']."</td>";
            echo "<td>".$row['PatientType']."</td>";
            echo "<td>".$row['TestDate']."</td>";
            echo "<td>".$row['ResultDate']."</td>";
            echo "<td>".$row['Status']."</td>";
            echo "</tr>";

          }
        }
        $conn->close();
        echo "</tbody>";
        ?>
        </table>
          </div>

          <div class="modal fade" id="resultsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="exampleModalLongTitle">Test Results</h4>
                  <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <b id="tResults"></b>
                  <br>
                </div>
                </div>
                </div>
                </div>
      </main>
          <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
          <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script type="text/javascript" src="../scripts/CoViewJS.js"></script>
          <script type="text/javascript">
            getReportDetails();
            sort();
          </script>
        </body>

</html>