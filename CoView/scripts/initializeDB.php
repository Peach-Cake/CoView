<?php
$conn = new mysqli("localhost", "root", "");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error . "<br>");
}

// Create database
$sql = "CREATE DATABASE CoViewDB";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully<br>";
} else {
  echo "Error creating database: " . $conn->error . "<br>";
  exit;
}
$conn->close();

//createTables
$conn = new mysqli("localhost", "root", "", "CoViewDB");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error . "<br");
}

//TestCentre
$sql = "CREATE TABLE TestCentre (
  CentreID INT(5) UNSIGNED UNIQUE AUTO_INCREMENT PRIMARY KEY,
  CentreName VARCHAR(20) NOT NULL UNIQUE,
  AddressLine1 VARCHAR(30) NOT NULL,
  AddressLine2 VARCHAR(30) NOT NULL,
  State VARCHAR(20) NOT NULL,
  Postcode int(5) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
  echo "Table TestCentre created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error . "<br>";
}

//User
$sql = "CREATE TABLE User (
ID BIGINT(10) UNSIGNED UNIQUE AUTO_INCREMENT PRIMARY KEY,
Username VARCHAR(20) NOT NULL UNIQUE,
Password VARCHAR(255) NOT NULL,
Name VARCHAR(50) NOT NULL,
Email VARCHAR(60) NOT NULL UNIQUE,
UserType CHAR(7) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
  echo "Table User created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error . "<br>";
}

//Officer
$sql = "CREATE TABLE Officer (
UserID BIGINT(10) UNSIGNED UNIQUE,
Position VARCHAR(8) NOT NULL,
RegisteredCentreID INT(5) UNSIGNED,
FOREIGN KEY (UserID) REFERENCES User(ID),
FOREIGN KEY (RegisteredCentreID) REFERENCES TestCentre(CentreID)
)";
if ($conn->query($sql) === TRUE) {
  echo "Table Officer created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error . "<br>";
}

//Patient
$sql = "CREATE TABLE Patient (
UserID BIGINT(10) UNSIGNED UNIQUE,
PatientType VARCHAR(15) NOT NULL,
Symptoms VARCHAR(100) NOT NULL,
FOREIGN KEY (UserID) REFERENCES User(ID)
)";
if ($conn->query($sql) === TRUE) {
  echo "Table Patient created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error . "<br>";
}

//TestKit
$sql = "CREATE TABLE TestKit (
KitID INT(5) UNSIGNED UNIQUE AUTO_INCREMENT PRIMARY KEY,
TestKitName VARCHAR(20) NOT NULL UNIQUE
)";
if ($conn->query($sql) === TRUE) {
  echo "Table TestKit created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error . "<br>";
}

//TestCentreKitStock
$sql = "CREATE TABLE TestCentreKitStock (
TestCentreID INT(5) UNSIGNED NOT NULL,
TestKitID INT(5) UNSIGNED NOT NULL,
AvailableStock INT(3) UNSIGNED NOT NULL,
FOREIGN KEY (TestCentreID) REFERENCES TestCentre(CentreID),
FOREIGN KEY (TestKitID) REFERENCES TestKit(KitID),
UNIQUE INDEX CentreKit(TestCentreID, TestKitID)
)";
if ($conn->query($sql) === TRUE) {
  echo "Table TestCentreKitStock created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error . "<br>";
}

//TestCentreKitStock
$sql = "CREATE TABLE CovidTest (
TestID BIGINT(10) UNSIGNED UNIQUE AUTO_INCREMENT PRIMARY KEY,
OfficerUserID BIGINT(10) UNSIGNED NOT NULL,
PatientUserID BIGINT(10) UNSIGNED NOT NULL,
TestDate DATE NOT NULL,
Result VARCHAR(60) DEFAULT 'Test results not ready yet',
ResultDate DATE DEFAULT '0001-01-01',
Status VARCHAR(10) NOT NULL DEFAULT 'Pending',
TestKitID INT(5) UNSIGNED NOT NULL,
TestCentreID INT(5) UNSIGNED NOT NULL,
FOREIGN KEY (OfficerUserID) REFERENCES User(ID),
FOREIGN KEY (PatientUserID) REFERENCES User(ID),
FOREIGN KEY (TestCentreID) REFERENCES TestCentre(CentreID),
FOREIGN KEY (TestKitID) REFERENCES TestKit(KitID)
)";
if ($conn->query($sql) === TRUE) {
  echo "Table CovidTest created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error . "<br>";
}

$sql = "SELECT * FROM User";
$result = $conn->query($sql);
if(mysqli_num_rows($result) == 0){
  //insertTableData
  //TestCentre
  $sql = "INSERT INTO TestCentre(CentreName, AddressLine1, AddressLine2, State, Postcode)
  VALUES ('Centre1', '6 Jln Setuadungun 9', 'Bkt Damansara', 'Johor', 23401);";
  $sql .= "INSERT INTO TestCentre(CentreName, AddressLine1, AddressLine2, State, Postcode)
  VALUES ('Centre2', '4 Jln Bestari 2', 'Taman Tun', 'Pahang', 23331);";

  //User,Officer,Patient
  $password = password_hash('password', PASSWORD_DEFAULT);
  $sql .= "INSERT INTO User(Username, Password, Name, Email, UserType)
  VALUES ('Manager', '$password', 'Man Ager', 'manager@manager.com', 'Officer');";
  $sql .= "INSERT INTO Officer(UserID, Position, RegisteredCentreID)
  VALUES (1, 'Manager', 1);";
  $sql .= "INSERT INTO User(Username, Password, Name, Email, UserType)
  VALUES ('Tester', '$password', 'Tes Ter', 'tester@tester.com', 'Officer');";
  $sql .= "INSERT INTO Officer(UserID, Position, RegisteredCentreID)
  VALUES (2, 'Tester', 1);";
  $sql .= "INSERT INTO User(Username, Password, Name, Email, UserType)
  VALUES ('Patient', '$password', 'Pae Tient', 'patient@patient.com', 'Patient');";
  $sql .= "INSERT INTO Patient(UserID, PatientType, Symptoms)
  VALUES (3, 'Infected', 'Coughing and Tiredness');";
  $sql .= "INSERT INTO User(Username, Password, Name, Email, UserType)
  VALUES ('Manager2', '$password', 'Man Agertoo', 'manager2@manager.com', 'Officer');";
  $sql .= "INSERT INTO Officer(UserID, Position, RegisteredCentreID)
  VALUES (4, 'Manager', 2);";
  $sql .= "INSERT INTO User(Username, Password, Name, Email, UserType)
  VALUES ('Manager3', '$password', 'Man Agertree', 'manager3@manager.com', 'Officer');";
  $sql .= "INSERT INTO Officer(UserID, Position)
  VALUES (5, 'Manager');";
  $sql .= "INSERT INTO User(Username, Password, Name, Email, UserType)
  VALUES ('Patient2', '$password', 'Pay Chent', 'patient2@patient.com', 'Patient');";
  $sql .= "INSERT INTO Patient(UserID, PatientType, Symptoms)
  VALUES (6, 'Close Contact', 'Coughing and Tiredness');";
  $sql .= "INSERT INTO User(Username, Password, Name, Email, UserType)
  VALUES ('Patient3', '$password', 'Pei Sent', 'patient3@patient.com', 'Patient');";
  $sql .= "INSERT INTO Patient(UserID, PatientType, Symptoms)
  VALUES (7, 'Quarantined', 'Coughing and Tiredness');";
  $sql .= "INSERT INTO User(Username, Password, Name, Email, UserType)
  VALUES ('Patient4', '$password', 'Paen Fent', 'patient4@patient.com', 'Patient');";
  $sql .= "INSERT INTO Patient(UserID, PatientType, Symptoms)
  VALUES (8, 'Suspected', 'Coughing and Tiredness');";
  $sql .= "INSERT INTO User(Username, Password, Name, Email, UserType)
  VALUES ('Patient5', '$password', 'Pay Cent', 'patient5@patient.com', 'Patient');";
  $sql .= "INSERT INTO Patient(UserID, PatientType, Symptoms)
  VALUES (9, 'Returnee', 'Coughing and Tiredness');";

  //TestKit
  $sql .= "INSERT INTO TestKit(TestKitName)
  VALUES ('TestKit1');";
  $sql .= "INSERT INTO TestKit(TestKitName)
  VALUES ('TestKit2');";

  //TestCentreKitStock
  $sql .= "INSERT INTO TestCentreKitStock(TestCentreID, TestKitID, AvailableStock)
  VALUES (1,1,20);";
  $sql .= "INSERT INTO TestCentreKitStock(TestCentreID, TestKitID, AvailableStock)
  VALUES (1,2,25);";
  $sql .= "INSERT INTO TestCentreKitStock(TestCentreID, TestKitID, AvailableStock)
  VALUES (2,1,14);";
  $sql .= "INSERT INTO TestCentreKitStock(TestCentreID, TestKitID, AvailableStock)
  VALUES (2,2,18);";

  $sql .= "INSERT INTO CovidTest(OfficerUserID,PatientUserID,TestDate,TestKitID,TestCentreID)
  VALUES(2,3,'2020-08-25',1,1);";
  $sql .= "INSERT INTO CovidTest(OfficerUserID,PatientUserID,TestDate,TestKitID,TestCentreID)
  VALUES(2,6,'2020-02-05',1,1);";
  $sql .= "INSERT INTO CovidTest(OfficerUserID,PatientUserID,TestDate,Result,ResultDate,Status,TestKitID,TestCentreID)
  VALUES(2,7,'2020-01-22','Covid-Negative Confirmed','2020-01-30','Complete',1,1);";
  $sql .= "INSERT INTO CovidTest(OfficerUserID,PatientUserID,TestDate,Result,ResultDate,Status,TestKitID,TestCentreID)
  VALUES(2,8,'2020-04-12','Most Likely Covid-Positive','2020-04-18','Complete',1,1);";
  $sql .= "INSERT INTO CovidTest(OfficerUserID,PatientUserID,TestDate,TestKitID,TestCentreID)
  VALUES(2,9,'2020-03-17',1,1);";
  //add Data to tables
  if ($conn->multi_query($sql) === TRUE) {
    echo "New records created successfully<br>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
  }
}
else{
  echo "Data already initialized!<br>";
}
$conn->close();
 ?>