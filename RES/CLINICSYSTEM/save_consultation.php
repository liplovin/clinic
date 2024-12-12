<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "clinic_data";

$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $patientID = $connection->real_escape_string($_POST['patient_id']);
    $date = $connection->real_escape_string($_POST['date']);
    $timeIn = $connection->real_escape_string($_POST['time_in']);
    $timeOut = $connection->real_escape_string($_POST['time_out']);
    $subjective = $connection->real_escape_string($_POST['subjective']);
    $objective = $connection->real_escape_string($_POST['objective']);
    $assessment = $connection->real_escape_string($_POST['assessment']);
    $plan = $connection->real_escape_string($_POST['plan']);
    $planDate = $connection->real_escape_string($_POST['plan_date']);
    $savedBy = $connection->real_escape_string($_POST['saved_by']);

    // Insert data into the consultation table
    $sql = "INSERT INTO consultation (PatientID, Date, TimeIn, TimeOut, Subjective, Objective, Assessment, Plan, PlanDate, SavedBy)
            VALUES ('$patientID', '$date', '$timeIn', '$timeOut', '$subjective', '$objective', '$assessment', '$plan', '$planDate', '$savedBy')";

    if ($connection->query($sql) === TRUE) {
        echo "Consultation record saved successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }

    $connection->close();
}
?>
