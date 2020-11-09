<?php
session_start();
header("Access-Control-Allow-Origin: *");
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="CoView.css">
    <script src="CoViewJS.js"></script>
    <title>Patient Menu</title>
  </head>

  <body class="settings">
    <header>
      <h1>COVIEW</h1>
      <nav class="AccountMenu">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Account
          </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <div class="dropdown-header">Position: Patient</div>
          <a class="dropdown-item" href="#"></a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="index.html">Logout</a>
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
        <table>
          <thead>
          <tr>
            <th>Tester name</th>
            <th>Patient type</th>
            <th>Test date</th>
            <th>Result Date</th>
            <th>Symptoms</th>
          </tr>
        <tbody>
          <?php
          $conn = new mysqli("localhost", "root", "", "CoViewDB");
          $patientID = $_SESSION['LoggedIn'];
          $query = "SELECT * FROM ReportTable
          WHERE PatientID = '$patientID';";
          $result = $conn->query($query);
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
           ?>
      </tbody>
        </table>
          </div>

          <div>
            <script type="text/javascript" src="CoViewJS.js"></script>
          </div>
      </main>
          <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
          <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        </body>

</html>
