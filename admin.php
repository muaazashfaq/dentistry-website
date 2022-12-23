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
            <a href="admin.php" style="text-decoration: underline 5px solid pink; color: black;">ADMIN</a>
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
    <div class="admin-box">
        <br>
        <form method="post">
            <input type ="submit" value="Create" id='admin-button' name='button1'>
            <input type ="submit" value="Delete" id='admin-button' name='button2'>
            <input type ="submit" value="Populate" id='admin-button' name='button3'>
            <br>
            <select name="view" style="margin-top: 30px; width: 400px; border:1px solid black; text-transform: uppercase;">
                <option value="">Select...</option>
                <option value="highly-paid" name="highly-paid">Highly paid employees</option>
                <option value="expensive-equipment" name="expensive-equipment">Expensive equipment</option>
                <option value="calendar" name="calendar">Calendar - Appointments with names</option>
            </select>
            <input type="submit" id='submit-button' name="form-submit" style="border:1px solid black;">
        </form>

    </div>
            <?php
                if(isset($_POST['button1'])) {
                    $array = array("CREATE TABLE patient(
                        patient_id NUMBER PRIMARY KEY,
                        patient_name VARCHAR2(70) NOT NULL,
                        phone_number VARCHAR2(12) NOT NULL,
                        health_card VARCHAR2(20) NOT NULL,
                        address VARCHAR2(200) NOT NULL
                        )", 
                        "CREATE TABLE staff(
                            employee_id NUMBER PRIMARY KEY,
                            employee_name VARCHAR2(70) NOT NULL,
                            title VARCHAR2(20) NOT NULL,
                            phone_number VARCHAR2(12) NOT NULL,
                            sin_number VARCHAR2(10) NOT NULL,
                            address VARCHAR2(200) NOT NULL
                        )",
                        "CREATE TABLE appointments(
                            appointment_id NUMBER PRIMARY KEY,
                            appointment_date DATE NOT NULL,
                            appointment_type VARCHAR2(250) NOT NULL,
                            employee_id NUMBER REFERENCES staff(employee_id),
                            patient_id NUMBER REFERENCES patient(patient_id)
                        )",
                        "CREATE TABLE equipment(
                            equipment_id NUMBER PRIMARY KEY,
                            equipment_name VARCHAR2(50) NOT NULL,
                            equipment_cost NUMBER NOT NULL,
                            repair_contact VARCHAR2(100) NOT NULL,
                            date_purchased DATE NOT NULL
                        )",
                        "CREATE TABLE dentist(
                            employee_id NUMBER REFERENCES staff(employee_id),
                            certificate_number NUMBER NOT NULL,
                            specialization VARCHAR2(20),
                            PRIMARY KEY(employee_id)
                        )",
                        "CREATE TABLE dentalstudent(
                            employee_id NUMBER REFERENCES staff(employee_id),
                            school VARCHAR(40) NOT NULL,
                            PRIMARY KEY(employee_id)
                        )",
                        "CREATE TABLE PAYROLL (
                            employee_bank_number NUMBER PRIMARY KEY NOT NULL,
                            salary NUMBER NOT NULL,
                            employee_id NUMBER,
                            FOREIGN KEY (employee_id) REFERENCES staff(employee_id)
                        )",
                        "CREATE TABLE payment_history(
                            payment_id NUMBER PRIMARY KEY,
                            amount_deposited NUMBER NOT NULL,
                            employee_id NUMBER REFERENCES staff(employee_id),
                            payment_date DATE NOT NULL
                        )"
                        );
                    $r = false;
                    foreach ($array as $query) {
                        $stid = oci_parse($conn, $query);
                        $r = oci_execute($stid);
                        $m = oci_error();
                    }
                    if($r){
                        echo "<div style= \"    display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;\">
                        <h1 style=\"color:#fcdcdc\"> Tables Created </h1>
                    </div>
                        ";

                    }
                    else {
                        echo "<div style= \"    display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;\">
                        <h1 style=\"color:#fcdcdc\"> Tables Already Exist </h1>
                    </div>
                        ";
                    }
                }
                if(isset($_POST['button2'])) {
                    $array = array ("DROP TABLE APPOINTMENTS CASCADE CONSTRAINTS",
                    "DROP TABLE DENTALSTUDENT CASCADE CONSTRAINTS",
                    "DROP TABLE DENTIST CASCADE CONSTRAINTS",
                    "DROP TABLE EQUIPMENT CASCADE CONSTRAINTS",
                    "DROP TABLE PATIENT CASCADE CONSTRAINTS",
                    "DROP TABLE PAYMENT_HISTORY CASCADE CONSTRAINTS",
                    "DROP TABLE PAYROLL CASCADE CONSTRAINTS",
                    "DROP TABLE STAFF CASCADE CONSTRAINTS");
                    $r = false;
                    foreach ($array as $query) {
                        $stid = oci_parse($conn, $query);
                        $r = oci_execute($stid);
                        $m = oci_error();
                    }
                    if($r){
                        echo "<div style= \"    display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;\">
                        <h1 style=\"color:#fcdcdc\"> Tables Dropped </h1>
                    </div>
                        ";

                    }
                    else {
                        echo "<div style= \"    display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;\">
                        <h1 style=\"color:#fcdcdc\"> Tables don't exist </h1>
                    </div>
                        ";
                    }
                }
                if(isset($_POST['button3'])) {
                    $array = array ("INSERT INTO staff (employee_id, employee_name, title, phone_number, sin_number, address)
                    VALUES (1,'John Abhari','Dentist', '647123000', '987654321', '26 House Road, City, State')",
                    "INSERT INTO staff (employee_id, employee_name, title, phone_number, sin_number, address)
                    VALUES (2,'Billy Keshani','Dentist', '647000000', '987456321', '27 House Road, City, State')",
                    "INSERT INTO staff (employee_id, employee_name, title, phone_number, sin_number, address)
                    VALUES (3,'Jim Keshani','Student', '6478888888', '946281321', '29 House Road, City, State')",
                    "INSERT INTO staff (employee_id, employee_name, title, phone_number, sin_number, address)
                    VALUES (4,'Thomas Keshani','Student', '6478956888', '925891321', '31 House Road, City, State')",
                    "INSERT INTO dentist (employee_id, certificate_number, specialization)
                    VALUES (1, 123123123, 'teeth')",
                    "INSERT INTO dentist (employee_id, certificate_number, specialization)
                    VALUES (2, 321321321, 'front teeth')",
                    "INSERT INTO dentalstudent (employee_id, school)
                    VALUES (3, 'Ryerson')",
                    "INSERT INTO dentalstudent (employee_id, school)
                    VALUES (4, 'U of T')",
                    "INSERT INTO patient (patient_id, patient_name, phone_number, health_card, address)
                    VALUES (2,'Farshad Keshani', '6470000000', '1234567000', '25 House Road, City, State')",
                    "INSERT INTO patient (patient_id, patient_name, phone_number, health_card, address)
                    VALUES (1,'Abdolreza Abhari', '6471231234', '1234567890', '24 House Road, City, State')",
                    "INSERT INTO appointments (appointment_id, appointment_date, appointment_type, employee_id, patient_id)
                    VALUES (1, TO_DATE('12/12/2020','MM/DD/YYYY'), 'checkup', 1, 1)",
                    "INSERT INTO appointments (appointment_id, appointment_date, appointment_type, employee_id, patient_id)
                    VALUES (2, TO_DATE('12/13/2020','MM/DD/YYYY'), 'checkup', 2, 2)",
                    "INSERT INTO payroll (employee_id, employee_bank_number, salary)
                    VALUES (1, 123123123, 100000)",
                    "INSERT INTO payroll (employee_id, employee_bank_number, salary)
                    VALUES(2, 123456789, 75000)",
                    "INSERT INTO patient (patient_id, patient_name, phone_number, health_card, address)
                    VALUES (1,'Abdolreza Abhari', '6471231234', '1234567890', '24 House Road, City, State')",
                    "INSERT INTO appointments (appointment_id, appointment_date, appointment_type, employee_id, patient_id)
                    VALUES (1, TO_DATE('12/12/2020','MM/DD/YYYY'), 'checkup', 1, 1)",
                    "INSERT INTO appointments (appointment_id, appointment_date, appointment_type, employee_id, patient_id)
                    VALUES(2, TO_DATE('12/13/2020','MM/DD/YYYY'), 'checkup', 2, 2)",
                    "INSERT INTO payroll (employee_id, employee_bank_number, salary)
                    VALUES (1, 123123123, 100000)",
                    "INSERT INTO payroll(employee_id, employee_bank_number, salary)
                    VALUES (2, 123456789, 75000)",
                    "INSERT INTO payroll (employee_id, employee_bank_number, salary)
                    VALUES (3, 987654321, 100000)",
                    "INSERT INTO equipment (equipment_id, equipment_name, equipment_cost, repair_contact, date_purchased) VALUES (1,'X-ray', 5000, '416-321-5323', TO_DATE('12/12/2020', 'MM/DD/YYYY'))",
                    "INSERT INTO equipment (equipment_id, equipment_name, equipment_cost, repair_contact, date_purchased) VALUES (2,'Cleaning-System', 3000, '647-503-9703', TO_DATE('6/3/2021', 'MM/DD/YYYY'))",
                    "INSERT INTO equipment (equipment_id, equipment_name, equipment_cost, repair_contact, date_purchased) VALUES (3,'Lighting System', 9000, '905-273-5231', TO_DATE('10/17/2021', 'MM/DD/YYYY'))",
                    "INSERT INTO equipment (equipment_id, equipment_name, equipment_cost, repair_contact, date_purchased) VALUES (4,'Equipment Cleaning System', 5000, '289-243-1591', TO_DATE('3/11/2021', 'MM/DD/YYYY'))",
                    "INSERT INTO equipment (equipment_id, equipment_name, equipment_cost, repair_contact, date_purchased) VALUES (5,'Advanced Lighting System', 10000, '905-273-5231', TO_DATE('11/23/2021', 'MM/DD/YYYY'))",
                    "INSERT INTO payment_history (amount_deposited, payment_date, payment_id,employee_id)
                    VALUES (2400, TO_DATE('10/17/2021', 'MM/DD/YYYY'), 1,3)",
                    "INSERT INTO payment_history (amount_deposited, payment_date, payment_id,employee_id)
                    VALUES (1200, TO_DATE('10/17/2021', 'MM/DD/YYYY'), 2,4)");
                    $r = false;
                    foreach ($array as $query) {
                        $stid = oci_parse($conn, $query);
                        $r = oci_execute($stid);
                        $m = oci_error();
                    }
                    if($r){
                        echo "<div style= \"    display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;\">
                        <h1 style=\"color:#fcdcdc\"> Tables Populated </h1>
                    </div>
                        ";

                    }
                    else {
                        echo "<div style= \"    display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;\">
                        <h1 style=\"color:#fcdcdc\"> Tables already populated </h1>
                    </div>
                        ";
                    }
                }
            ?>

<?php
    if(isset($_POST['form-submit'])){
    if(!empty($_POST['view'])) {
        $selected = $_POST['view'];

        if ($selected == "highly-paid") {
            echo "<div class=\"table-border\" style=\"padding-top:25px;\">";
            echo "<table border=\"1\" style=\"width:100%\">";
            $query = "SELECT * FROM highly_paid";
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);
            // foreach(array_keys($row) as $key){
            //     echo "<tr>$key</tr>";
            // }
            $counter = 0;
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
            echo "</table>";
            echo "</div>";
        }
        elseif ($selected == "expensive-equipment") {
            echo "<div class=\"table-border\" style=\"padding-top:25px;\">";
            echo "<table border=\"1\" style=\"width:100%\">";
            $query = "SELECT * FROM expensive_equipment";
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);
            // foreach(array_keys($row) as $key){
            //     echo "<tr>$key</tr>";
            // }
            $counter = 0;
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
            echo "</table>";
            echo "</div>";
        }
        elseif ($selected == "calendar") {
            echo "<div class=\"table-border\" style=\"padding-top:25px;\">";
            echo "<table border=\"1\" style=\"width:100%\">";
            $query = "SELECT * FROM calendar";
            $stid = oci_parse($conn, $query);
            $r = oci_execute($stid);
            // foreach(array_keys($row) as $key){
            //     echo "<tr>$key</tr>";
            // }
            $counter = 0;
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