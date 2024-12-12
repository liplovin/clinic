<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "clinic_data";


$connection = new mysqli($servername, $username, $password, $database);


if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$last_name = $connection->real_escape_string($_POST['LastName']);
$first_name = $connection->real_escape_string($_POST['FirstName']);
$middle_initial = $connection->real_escape_string($_POST['MiddleInitial']);
$sex = $connection->real_escape_string($_POST['Sex']);
$age = intval($_POST['age']);
$civil_status = $connection->real_escape_string($_POST['civil_status']);
$address = $connection->real_escape_string($_POST['Address']);
$cellphone = $connection->real_escape_string($_POST['ContactNumber']);
$emergency_number = $connection->real_escape_string($_POST['emergency_number']);
$guardian = $connection->real_escape_string($_POST['guardian']);
$height = floatval($_POST['height']);
$weight = floatval($_POST['weight']);


$sql = "INSERT INTO patients (LastName, FirstName, MiddleInitial, sex, age, civil_status, Address, ContactNumber, emergency_number, guardian, height, weight)
        VALUES ('$last_name', '$first_name', '$middle_initial', '$sex', $age, '$civil_status', '$address', '$cellphone', '$emergency_number', '$guardian', $height, $weight)";

if ($connection->query($sql) === TRUE) {
    echo "<script>alert('New patient added successfully!'); window.location.href='index.html';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $connection->error;
}

$connection->close();
?>