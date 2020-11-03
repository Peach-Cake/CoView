<?php
session_start()
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
            Account
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

      <div class="form-container">
          <form id="form">
                <label for="testerName"><b>Tester: </b></label>
                <br>
                <input type="text" name="testerName" size="50" required>
                <br><br>
                <label for="patientName"><b>Patient name: </b></label>
                <br>
                <input type="text" name="patientName" size="50" required>
                <br><br>
                <label for="username"><b>Username: </b></label>
                <br>
                <input type="text" name="username" size="50" required>
                <br><br>
                <label for="password"><b>Password: </b></label>
                <br>
                <input type="password" name="password" size="50" required>
                <br><br>
                <label for="patientType"><b>Patient type:</b></label>
                <select id="patientType">
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
                <br><br><br>

                <div class="buttons">
                  <button class="SDBtn" type="button">Delete</button>
                  <button class="SDBtn" type="submit">Save</button>
                </div>
              </form>
            </div>


            <div class="btn-container">
            <a href=""><button class="sideBtns">Create report</button></a>
            </div>

            <div class="btn-container">
            <a href="testerMenu.php"><button class="sideBtns">View report table</button></a>
            </div>







</html>
