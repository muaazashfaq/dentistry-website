<!DOCTYPE html>
<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');
// Create connection to Oracle
$conn = oci_connect('username', 'password', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=oracle.scs.ryerson.ca)(Port=1521))(CONNECT_DATA=(SID=orcl)))');
if (!$conn) {
 $m = oci_error();
 echo $m['message'];
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
<style>
        table, th, td,tr {
         border:1px solid black;
         font-family: 'Open Sans', sans-serif;
         text-align: center;
        }

        th {
            background-color: rgba(253, 147, 165, 0.733);
        }
        tr {
            background-color: #f2dbda;
        }
        /* tr:nth-child(even) {
            background-color: #D6EEEE;
        }
        tr:nth-child(odd) {
            background-color: #a7eafc;
        } */

        tr:hover {
            background-color: #eda4a4;
        }

        .table-border {
            display: flex;
            margin-top: 15vh;
            margin-left: 15vw;
            justify-content: center;
            width: 1000px;
            background-color: rgba(253, 147, 165, 0.733);
            padding-top: 0;
            box-shadow: 20px 20px 15px black ;
            border-radius: 10px;
        }      
</style>

<body style="background-color: rgba(0, 0, 0, 0.829);">
    <div class="navbar-container" style="background-color: white; margin-top: 0px; border-bottom: 5px solid black;">
        <div class="nav">
            <a href="index.php">HOME</a>
            <a href="admin.php">ADMIN</a>
            <a href="query.php" style="text-decoration: underline 5px solid pink; color: black;">QUERY</a>
        </div>
        <div class="Dentist-Title">
            Keshani Dentistry
        </div>
        <div class="userIcon">
            <p1>Farshad Keshani</p1>
            <img src="user.png" id="userIcon">
        </div>
    </div>
    <div class="query-box">
        <p1 style="margin-top: 0;">QUERY</p1>
        <br>
        <form method="post">
            <select name="view" style="width: 380px; background-color: white; border: 1px solid black; border-radius: 50px;">
                <option value="">Select... </option>
                <option name="appointments" value="appointments">View appointments table</option>
                <option name="staff" value="staff">View staff table</option>
                <option name="patients" value="patients">View patients table</option>
                <option name="dentists" value="dentists">View dentists table</option>
                <option name="payment_history" value="payment_history">View payment history table</option>
                <option name="equipment" value="equipment">View equipment table</option>
                <option name="student" value="student">View dental student table</option>
                <option name="payroll" value="payroll">View payroll table</option>
                <option name="join1" value="join1">View emp name + payment</option>
                <option name="join2" value="join2">View appointment + patient name + doctor</option>
            </select>
            <input type ="submit" name="form-submit" style="border-radius: 70px; border: 1px solid black;">
            <br>
            <input type ="text" name="custom" style="width: 375px; background-color: white; border: 1px solid black; border-radius: 50px; margin-top:10px;" placeholder="Enter Query">
            <input type="submit" name="other-form-submit" style="border-radius: 70px; border: 1px solid black;">
        </form>
    </div>
    <?php
    if(isset($_POST['other-form-submit'])){
        if(!empty($_POST['custom'])){
            $theQuery = $_POST['custom'];
            $theCheck = strtok($theQuery, " ");
            echo "<div class=\"table-border\" style=\"padding-top:25px;\">";
            echo "<table border=\"1\" style=\"width:100%\">";
            $stid = oci_parse($conn, $theQuery);
            $r = oci_execute($stid);
            $counter = 0;
            if (strtoupper($theCheck) == "SELECT"){
            if ($r) {
                while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
                    $counter += 1;
                    if ($counter == 1) {
                        echo "<tr>";
                            foreach(array_keys($row) as $key){
                                echo "<th>$key</th>";
                            }
                        echo "</tr>";

                    }
                    echo "<tr>";
                    foreach($row as $val){
                        echo "<td>$val</td>";
                    }
                    echo "</tr>";
                }
            }
            else {
                echo "No table data";
            }
            echo "</table>";
            echo "</div>";
        }
        else {
            $stid = oci_parse($conn, $theQuery);
            $r = oci_execute($stid);
            $m = oci_error();
            echo "Query completed.";
        }
    }
    }

    ?>
    <?php
    if(isset($_POST['form-submit'])){
    if(!empty($_POST['view'])) {
        $selected = $_POST['view'];

        if ($selected == "appointments") {
            echo "<div class=\"table-border\" style=\"padding-top:25px;\">";
            echo "<table border=\"1\" style=\"width:100%\">";
            $query = "SELECT * FROM appointments";
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);
            // foreach(array_keys($row) as $key){
            //     echo "<tr>$key</tr>";
            // }
            $counter = 0;
            if ($r) {
                while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
                    $counter += 1;
                    if ($counter == 1) {
                        echo "<tr>";
                            foreach(array_keys($row) as $key){
                                echo "<th>$key</th>";
                            }
                        echo "</tr>";

                    }
                    echo "<tr>";
                    foreach($row as $val){
                        echo "<td>$val</td>";
                    }
                    echo "</tr>";
                }
            }
            else {
                echo "No table data";
            }
            echo "</table>";
            echo "</div>";
        }
        elseif ($selected == "staff") {
            echo "<div class=\"table-border\" style=\"padding-top:25px;\">";
            echo "<table border=\"1\" style=\"width:100%\">";
            $query = "SELECT * FROM staff";
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);
            // foreach(array_keys($row) as $key){
            //     echo "<tr>$key</tr>";
            // }
            $counter = 0;
            if ($r){
                while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
                    $counter += 1;
                    if ($counter == 1) {
                        echo "<tr>";
                            foreach(array_keys($row) as $key){
                                echo "<th>$key</th>";
                            }
                        echo "</tr>";

                    }
                    echo "<tr>";
                    foreach($row as $val){
                        echo "<td>$val</td>";
                    }
                    echo "</tr>";
                }
            }
            else {
                echo "No table data";
            }
            echo "</table>";
            echo "</div>";
        }
        elseif ($selected == "patients") {
            echo "<div class=\"table-border\" style=\"padding-top:25px;\">";
            echo "<table border=\"1\" style=\"width:100%\">";
            $query = "SELECT * FROM patient";
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);
            // foreach(array_keys($row) as $key){
            //     echo "<tr>$key</tr>";
            // }
            $counter = 0;
            if ($r) {
                while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
                    $counter += 1;
                    if ($counter == 1) {
                        echo "<tr>";
                            foreach(array_keys($row) as $key){
                                echo "<th>$key</th>";
                            }
                        echo "</tr>";

                    }
                    echo "<tr>";
                    foreach($row as $val){
                        echo "<td>$val</td>";
                    }
                    echo "</tr>";
                }
            }
            else {
                echo "No table data";
            }
            echo "</table>";
            echo "</div>";
        }
        elseif ($selected == "dentists") {
            echo "<div class=\"table-border\" style=\"padding-top:25px;\">";
            echo "<table border=\"1\" style=\"width:100%\">";
            $query = "SELECT * FROM dentist";
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);
            // foreach(array_keys($row) as $key){
            //     echo "<tr>$key</tr>";
            // }
            $counter = 0;
            if ($r) {
                while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
                    $counter += 1;
                    if ($counter == 1) {
                        echo "<tr>";
                            foreach(array_keys($row) as $key){
                                echo "<th>$key</th>";
                            }
                        echo "</tr>";

                    }
                    echo "<tr>";
                    foreach($row as $val){
                        echo "<td>$val</td>";
                    }
                    echo "</tr>";
                }
            }
            else {
                echo "No table data";
            }
            echo "</table>";
            echo "</div>";
        }
        elseif ($selected == "payment_history") {
            echo "<div class=\"table-border\" style=\"padding-top:25px;\">";
            echo "<table border=\"1\" style=\"width:100%\">";
            $query = "SELECT * FROM payment_history";
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);
            // foreach(array_keys($row) as $key){
            //     echo "<tr>$key</tr>";
            // }
            $counter = 0;
            if ($r) {
                while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
                    $counter += 1;
                    if ($counter == 1) {
                        echo "<tr>";
                            foreach(array_keys($row) as $key){
                                echo "<th>$key</th>";
                            }
                        echo "</tr>";

                    }
                    echo "<tr>";
                    foreach($row as $val){
                        echo "<td>$val</td>";
                    }
                    echo "</tr>";
                }
            }
            else {
                echo "No table data";
            }
            echo "</table>";
            echo "</div>";
        }
        elseif ($selected == "equipment") {
            echo "<div class=\"table-border\" style=\"padding-top:25px;\">";
            echo "<table border=\"1\" style=\"width:100%\">";
            $query = "SELECT * FROM equipment";
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);
            // foreach(array_keys($row) as $key){
            //     echo "<tr>$key</tr>";
            // }
            $counter = 0;
            if ($r) {
                while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
                    $counter += 1;
                    if ($counter == 1) {
                        echo "<tr>";
                            foreach(array_keys($row) as $key){
                                echo "<th>$key</th>";
                            }
                        echo "</tr>";

                    }
                    echo "<tr>";
                    foreach($row as $val){
                        echo "<td>$val</td>";
                    }
                    echo "</tr>";
                }
            }
            else {
                echo "No table data";
            }
            echo "</table>";
            echo "</div>";
        }
        elseif ($selected == "student") {
            echo "<div class=\"table-border\" style=\"padding-top:25px;\">";
            echo "<table border=\"1\" style=\"width:100%\">";
            $query = "SELECT * FROM dentalstudent";
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);
            // foreach(array_keys($row) as $key){
            //     echo "<tr>$key</tr>";
            // }
            $counter = 0;
            if ($r) {
                while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
                    $counter += 1;
                    if ($counter == 1) {
                        echo "<tr>";
                            foreach(array_keys($row) as $key){
                                echo "<th>$key</th>";
                            }
                        echo "</tr>";

                    }
                    echo "<tr>";
                    foreach($row as $val){
                        echo "<td>$val</td>";
                    }
                    echo "</tr>";
                }
            }
            else {
                echo "No table data";
            }
            echo "</table>";
            echo "</div>";
        }
        elseif ($selected == "payroll") {
            echo "<div class=\"table-border\" style=\"padding-top:25px;\">";
            echo "<table border=\"1\" style=\"width:100%\">";
            $query = "SELECT * FROM payroll";
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);
            // foreach(array_keys($row) as $key){
            //     echo "<tr>$key</tr>";
            // }
            $counter = 0;
            if ($r) {
                while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
                    $counter += 1;
                    if ($counter == 1) {
                        echo "<tr>";
                            foreach(array_keys($row) as $key){
                                echo "<th>$key</th>";
                            }
                        echo "</tr>";

                    }
                    echo "<tr>";
                    foreach($row as $val){
                        echo "<td>$val</td>";
                    }
                    echo "</tr>";
                }
            }
            else {
                echo "No table data";
            }
            echo "</table>";
            echo "</div>";
        }
        elseif ($selected == "join1") {
            echo "<div class=\"table-border\" style=\"padding-top:25px;\">";
            echo "<table border=\"1\" style=\"width:100%\">";
            $query = "SELECT
            staff.employee_name,
            staff.title,
            payroll.salary,
            payment_history.payment_id,
            payment_history.payment_date
        FROM staff
        JOIN payroll
          ON staff.employee_id= payroll.employee_id
        JOIN payment_history
          ON staff.employee_id = payment_history.employee_id";
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);
            // foreach(array_keys($row) as $key){
            //     echo "<tr>$key</tr>";
            // }
            $counter = 0;
            if ($r) {
                while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
                    $counter += 1;
                    if ($counter == 1) {
                        echo "<tr>";
                            foreach(array_keys($row) as $key){
                                echo "<th>$key</th>";
                            }
                        echo "</tr>";

                    }
                    echo "<tr>";
                    foreach($row as $val){
                        echo "<td>$val</td>";
                    }
                    echo "</tr>";
                }
            }
            else {
                echo "No table data";
            }
            echo "</table>";
            echo "</div>";
        }
        elseif ($selected == "join2") {
            echo "<div class=\"table-border\" style=\"padding-top:25px;\">";
            echo "<table border=\"1\" style=\"width:100%\">";
            $query = "SELECT
            appointments.appointment_id,
            appointments.appointment_date,
            patient.patient_name,
            staff.employee_name
        FROM appointments
        JOIN patient
          ON patient.patient_id = appointments.patient_id
        JOIN staff
          ON staff.employee_id = appointments.employee_id";
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);
            // foreach(array_keys($row) as $key){
            //     echo "<tr>$key</tr>";
            // }
            $counter = 0;
            if ($r) {
                while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
                    $counter += 1;
                    if ($counter == 1) {
                        echo "<tr>";
                            foreach(array_keys($row) as $key){
                                echo "<th>$key</th>";
                            }
                        echo "</tr>";

                    }
                    echo "<tr>";
                    foreach($row as $val){
                        echo "<td>$val</td>";
                    }
                    echo "</tr>";
                }
            }
            else {
                echo "No table data";
            }
            echo "</table>";
            echo "</div>";
        }
    } 
    
    else {
        echo 'Please select the value.';
    }
    }
?>
    
</body>
</html>