<!DOCTYPE html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
// Create connection to Oracle
$conn = oci_connect('username', 'password', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=oracle.scs.ryerson.ca)(Port=1521))(CONNECT_DATA=(SID=orcl)))');
if (!$conn) {
 $m = oci_error();
 echo $m['message'];
}
?>

<?php
// Get Number of Patients
$query = "SELECT COUNT(DISTINCT PATIENT_NAME) AS \"Number of employees\" FROM PATIENT " ;
$stid = oci_parse($conn, $query);
$r = oci_execute($stid);
$patients = null;
if($r){
 // Fetch each row in an associative array
    if (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
        $patients = $row[0];
    }
} 
//Get number of appointments
$query = "SELECT COUNT(DISTINCT APPOINTMENT_ID) FROM appointments" ;
$stid = oci_parse($conn, $query);
$r = oci_execute($stid);
$appointments = null;
if($r){
 // Fetch each row in an associative array
    if (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
        $appointments = $row[0];
    }
}
//Get number of employees
$query = "SELECT COUNT(DISTINCT EMPLOYEE_ID) FROM staff" ;
$stid = oci_parse($conn, $query);
$r = oci_execute($stid);
$employees = null;
if($r){
 // Fetch each row in an associative array
    if (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
        $employees = $row[0];
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;400&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Sono:wght@600&display=swap" rel="stylesheet">
    <title>Dentist Database</title>
</head>
<body style="background-color: rgba(0, 0, 0, 0.829);">
    <div class="navbar-container" style="background-color: white; margin-top: 0px; border-bottom: 5px solid black;">
        <div class="nav">
            <a href="index.php" style="text-decoration: underline 5px solid pink; color: black;">HOME</a>
            <a href="admin.php">ADMIN</a>
            <a href="query.php">QUERY</a>
        </div>
        <div class="Dentist-Title">
            Keshani Dentistry
        </div>
        <div class="userIcon">
            <p1>Farshad Keshani</p1>
            <img src="user.png" id="userIcon">
        </div>
    </div>
    <div class="display-panel">
        <div class="grid-item">
            <p1 id="grid-title">Total Patient Count:</p1>
            <br>
            <?php 
            echo "<p1 id=\"grid-number\">$patients</p1>"
            ?>
        </div>
        <div class="grid-item">
            <p1 id="grid-title">Appointment Count:</p1>
            <br>
            <?php 
            echo "<p1 id=\"grid-number\">$appointments</p1>"
            ?>
        </div>
        <div class="grid-item">
            <p1 id="grid-title">Number of Employees:</p1>
            <br>
            <?php 
            echo "<p1 id=\"grid-number\">$employees</p1>"
            ?>
        </div>
    </div>
    
</body>
</html>

