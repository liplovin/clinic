<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Patient</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f8ff; /* Light blue background */
        }
        .sidebar {
            background-color: #aad8e6;
        }
        .panel {
            border-radius: 10px;
        }
        .panel-heading {
            background-color: #0066cc;
            color: white;
            padding: 10px;
            border-radius: 10px 10px 0 0;
        }
        .form-control {
            margin-bottom: 10px;
        }
        .btn-primary {
            background-color: #0066cc;
            border: none;
        }
        .btn-primary:hover {
            background-color: #004b99;
        }
        .error, .text-danger {
            color: red;
        }
        .header {
        background-color: #20B2AA;
        color: white;
        padding: 20px;
        display: flex; /* Use flexbox for alignment */
        align-items: center; /* Center vertically */
        justify-content: flex-start;
        }
        .logo {
        width: 70px; /* Adjust logo size */
        height: auto;
        margin-right: 10px; /* Add some space between the logo and the text */
        }
        .header h1 {
            display: inline-block;
            margin-left: 20px;
        }
    </style>
</head>
<body>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "clinic_data";

    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection Failed: " . $connection->connect_error);
    }
?>
<!-- Header Section with Logo -->
<div class= "header d-flex align-items-center"> 
    <img src="images/UDMCLINIC_LOGO.png" alt="Logo" class="logo">
    <h1>UDM Clinic</h1>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><span class="glyphicon glyphicon-th"></span> Add New Patient</h4>
                </div>
                <div class="panel-body">
                    <form method="post" action="add_patient_backend.php">
                        <!-- Personal Details Fields -->
                        <div class="form-group">
                            <input type="text" class="form-control" name="LastName" placeholder="Last Name" value="" required>
                            <input type="text" class="form-control" name="FirstName" placeholder="First Name" value="" required>
                            <input type="text" class="form-control" name="MiddleInitial" placeholder="Middle Name" value="">
                            <input type="text" class="form-control" name="Sex" placeholder="Sex (M/F)" value="" required>
                            <input type="number" class="form-control" name="age" placeholder="Age" value="" required>
                            <input type="text" class="form-control" name="civil_status" placeholder="Civil Status" value="" required>
                        </div>
                        <!-- Address and Contact Information -->
                        <div class="form-group">
                            <input type="text" class="form-control" name="Address" placeholder="Address" value="" required>
                            <input type="tel" class="form-control" name="ContactNumber" placeholder="Cellphone Number" pattern="\d{10}" title="Enter a valid 10-digit number" value="" required>
                            <input type="tel" class="form-control" name="emergency_number" placeholder="Emergency Number" pattern="\d{10}" title="Enter a valid 10-digit number" value="">
                            <input type="text" class="form-control" name="guardian" placeholder="Parent/Guardian" value="" required>
                        </div>
                        <!-- Physical Attributes -->
                        <div class="form-group">
                            <input type="number" class="form-control" name="height" placeholder="Height (cm)" value="" required>
                            <input type="number" class="form-control" name="weight" placeholder="Weight (kg)" value="" required>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" name="add_product" class="btn btn-primary btn-block">
                            <span class="glyphicon glyphicon-plus-sign"></span> Add New Patient 
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>