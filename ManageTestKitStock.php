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
    <title>Manage Test Kit Stock</title>
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
          <a class="dropdown-item" href="index.html">Logout</a>
          </div>
        </div>
      </nav>
      </header>

      <nav aria-label="breadcrumb" class="navBreadCrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item" aria-current="page"><a href="http://localhost/ManagerMenu.php">Home</a></li>
          <li class="breadcrumb-item" aria-current="page">Manage Test Kit Stock</li>
        </ol>
      </nav>
      <div class="tkform-container">
        <label>Is it New Test Kit?</label>
        <br>
        <input type="radio" name="tkNew" value="yes" id="tkNewYes" checked onchange="neTestKitForm()">
        <label for="tkNewYes">Yes</label>
        <input type="radio" name="tkNew" value="no" id="tkNewNo" onchange="neTestKitForm()">
        <label for="tkNewNo">No</label>
        <br><br>
        <div class="testKitNew">
        <form id="tknform" action="" method="post" name="tknForm" onsubmit="">
          <small class="errorNotifications"></small>
          <br>
            <label for="tknName">Test Kit Name: </label>
            <br>
            <input type="text" name="tknName" id="tknName" size="50" required>
            <br><br>
            <label for="tknStock">Arrived Stock: </label>
            <br>
            <input type="number" name="tknStock" id="tknStock" size="3" min="1" required>
            <br><br><br><br><br>
            <div class="buttons">
              <button type="submit">Save</button>
            </div>
          </form>

          </div>
          <div class="testKitExists" style="display:none">
            <form id="tkeform" action="" method="post" name="tkeForm" >
            <label for="tkeName">Test Kit Name: </label>
            <br>
            <select name="tkeName" id="tkeName"  required>
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
            <br><br>
            <b id="tkeAvailableStock">Available Stock: </b>
            <br><br>
            <label for="tkeStock">Arrived Stock: </label>
            <br>
            <input type="number" name="tkeStock" id="tkeStock" size="3" value="0" required>
            <br><br>
            <b id="tkeNewStock">New Stock: </b>


          <br><br><br>
          <div class="buttons">
            <button type="submit">Save</button>
          </div>
        </form>
        </div>
      </div>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script type="text/javascript" src="CoViewJS.js">
      </script>
      <script type="text/javascript">
        neTestKitForm();
        addStock();
        getStock();
        nameChange();
        numChange();
        updateStock();
      </script>
    </body>
</html>
