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
    <title>Generate Test Report</title>
  </head>
  <body  class="settings">
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
          <a class="dropdown-item" href="http://localhost/logout.php">Logout</a>
          </div>
        </div>
      </nav>

    </header>
    <main>
    <nav aria-label="breadcrumb" class="navBreadCrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="http://localhost/ManagerMenu.php">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Generate Test Report</li>
      </ol>
    </nav>
    <div class="search-container">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <form action="/action_page.php">
      Search:  <input type="text" placeholder="Test report ID" name="searchReport">
      <button type="button" id="viewBtn" onclick="search()">View</button>
    </form>
  </div>
  <div  class="filterIcon">
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

<div id="modal" class="modal">
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

      <label>Result Date:</label>
      <input type="date" class="filterDates" name="resultDateFrom" value="">&nbsp;to
      <input type="date" class="filterDates" name="resultDateTo" value="">
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
<div class="report-container">
    <table id="reports">
      <thead>
      <tr>
        <th onclick="sortTable(0)">Test ID <img src=ascTableSorter.png class="tableSortPointers"></img></th>
        <th onclick="sortTable(1)">Patient name <img src=doubleTableSorter.png class="tableSortPointers"></img></th>
        <th onclick="sortTable(2)">Patient type <img src=doubleTableSorter.png class="tableSortPointers"></img></th>
        <th onclick="sortTable(3)">Test date <img src=doubleTableSorter.png class="tableSortPointers"></img></th>
        <th onclick="sortTable(4)">Result date <img src=doubleTableSorter.png class="tableSortPointers"></img></th>
        <th onclick="sortTable(5)">Status <img src=doubleTableSorter.png class="tableSortPointers"></img></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $centreID = $_SESSION["TestCentreID"];
      $conn = new mysqli("localhost", "root", "", "CoViewDB");
      $sql = "SELECT covidtest.TestID,user.Name,patient.PatientType,covidtest.TestDate,covidtest.ResultDate,covidtest.Status
      FROM ((covidtest INNER JOIN user ON covidtest.PatientUserID = user.ID)
      INNER JOIN patient ON covidtest.PatientUserID = patient.UserID) WHERE covidtest.TestCentreID='$centreID';";
      $result = $conn->query($sql);
      if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['TestID']."</td>";
        echo "<td>".$row['Name']."</td>";
        echo "<td>".$row['PatientType']."</td>";
        echo "<td>".$row['TestDate']."</td>";
        echo "<td>".$row['ResultDate']."</td>";
        echo "<td>".$row['Status']."</td>";
        echo "</tr>";
      }}
      $conn->close();
       ?>

    </tbody>
    </table>
  </div>
  <div id="resultsModal" class="modal">
    <div class="update-modal-content">
      <span class="close" onclick="xCloseFilter(1)">&times;</span>
    <div class="form-container1">
      <b id="tResults">Results: Appears to be Covid-Negative, but not completely certain.</b>
      <br>
      <!--<b id="pSymptoms">Symptoms: Coughing, Sore Throat, Fever.</b>-->
        </div>
        </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="CoViewJS.js"></script>
    <script type="text/javascript">
      getReportDetails();
    </script>
  </main>

  </body>
</html>