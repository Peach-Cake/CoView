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
    <title>Tester Menu</title>
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
           <div class="dropdown-divider"></div>
           <a class="dropdown-item" href="index.html">Log out</a>
         </div>
      </div>
      </nav>
    </header>

  <main>

      <?php
      $conn = new mysqli("localhost", "root", "", "CoViewDB");
      $query = "SELECT * FROM ReportTable";
      $result = $conn->query($query);
      echo "<table name='reports' style='position: relative;
        background-color: white;
        top: 50px;
        left: 40px;
        display: block;
        border: 3px solid white;
        text-align: center;
        width: 70%;
        float: right;
        overflow-y: scroll;
        overflow-x: hidden;
        height: 500px;'>
      <thead>
        <tr>
        <th>ID</th>
        <th>Patient Name</th>
        <th>Patient Type</th>
        <th>Test date</th>
        <th>Result date</th>
        <th>Status</th>
        </tr>
        </head>";

        while($row = mysqli_fetch_array($result))
        {
          echo "<tbody>";
        echo "<tr>";
        echo "<td>" . 'T' . $row['RecordID'] . "</td>";
        echo "<td>" . $row['PatientName'] . "</td>";
        echo "<td>" . $row['PatientType'] . "</td>";
        echo "<td>" . $row['TestDate'] . "</td>";
        echo "<td>" . $row['ResultDate'] . "</td>";
        echo "<td>" . $row['ReportStatus'] . "</td>";
        echo "</tr>";
        echo "</body>";
        }
        echo "</table>";

      ?>



    <div class="filterIcon1">
          <button id="filterButton1" onclick="openModal(0)">Filter
          <svg>
          <path fill-rule="evenodd"
          d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5
          0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5
          0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1
          .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5
          0 0 1 .128-.334L13.5 3.308V2h-11z"/>
        </svg></button>
        </div>

        <div id="filterModal" class="modal">
          <div class="filterModal-content">
            <span class="close" onclick="xCloseFilter(0)">&times;</span>
            <form class="filterForm" id="filterForm">
              <h4>Filter By:</h4>
              <label>Patient Type:</label>
              <input type="checkbox" id="returnee" name="patientStatus" value="returnee">
              <label for="returnee">Returnee</label>&nbsp;
              <input type="checkbox" id="quarantined" name="patientStatus" value="quarantined">
              <label for="quarantined">Quarantined</label>&nbsp;
              <input type="checkbox" id="closeContact" name="patientStatus" value="closeContact">
              <label for="closeContact">Close Contact</label>&nbsp;
              <input type="checkbox" id="infected" name="patientStatus" value="infected">
              <label for="infected">Infected</label>&nbsp;
              <input type="checkbox" id="suspected" name="patientStatus" value="suspected">
              <label for="suspected">Suspected</label>
              <br>

              <label>Test Date:</label>
              <input type="date" class="filterDates" name="testDateFrom" value="" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}">&nbsp;to
              <input type="date" class="filterDates" name="testDateTo" value="" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}">
              <br>

              <label>Status: </label>&nbsp;
              <input type="radio" id="pending" name="status" value="pending">
              <label for="pending">Pending</label>&nbsp;
              <input type="radio" id="complete" name="status" value="complete">
              <label for="complete">Complete</label>&nbsp;
              <input type="radio" id="both" name="status" value="both" checked>
              <label for="both">Both</label>
              <br>

              <button type="button"  onclick="applyFilter()">Apply</button>
            </form>
          </div>
        </div>




      <div class="btn-container">
      <a href="createNewRecord.php"><button class="sideBtns">Create report</button></a>
      </div>

      <div class="btn-container">
      <a href=""><button class="sideBtns">View report table</button></a>
      </div>


      <div class="search-container">

        <form action="" method="post">
          <br><br><br>
        Search:  <input type="text" placeholder="Test report ID" name="searchReport">
        <button type="submit" id="viewBtn">Update</button>

      </form>
      </div>

    <script type="text/javascript" src="CoViewJS.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </main>
</body>
</html>
