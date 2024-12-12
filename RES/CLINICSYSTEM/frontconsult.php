<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Form</title>
    <!-- Bootstrap CSS -->  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f8ff; /* Light blue background */
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
            font-size: 2.5rem;
            border-radius: 15px;
            padding: 10px 20px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            font-size: 1.5rem;
            border-radius: 15px 15px 0 0;
            padding: 15px;
        }
        .table {
            font-size: 1.1em;
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
<div class="header d-flex align-items-center"> 
    <img src="images/UDMCLINIC_LOGO.png" alt="Logo" class="logo">
    <h1>UDM Clinic</h1>
</div>

<div class="container mt-4">
    <div class="row">
        <!-- Search Patient Table -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Search Patient
                </div>
                <div class="card-body">
                    <form action="" method="GET">
                        <div class="form-group">
                            <label for="search">Search by Name or ID</label>
                            <input type="text" id="search" name="search" class="form-control" placeholder="Enter Name or ID" list="suggestions">
                            <datalist id="suggestions">
                                <?php
                                $suggestionQuery = "SELECT PatientID, FirstName, LastName FROM patients";
                                $suggestionResult = $connection->query($suggestionQuery);
                                while ($row = $suggestionResult->fetch_assoc()) {
                                    echo "<option value='" . $row['PatientID'] . " - " . $row['FirstName'] . " " . $row['LastName'] . "'>";
                                }
                                ?>
                            </datalist>
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                    <!-- Table for displaying search results -->
                    <div style="overflow-y: auto; max-height: 300px;">
                        <table class="table table-bordered table-striped mt-3">
                            <thead>
                                <tr>
                                    <th>Patient ID</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                    <th>Sex</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
$searchQuery = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = $connection->real_escape_string($_GET['search']);
    $searchParts = explode(" ", $searchTerm);
    $conditions = [];

    foreach ($searchParts as $part) {
        $part = $connection->real_escape_string($part);
        $conditions[] = "PatientID LIKE '%$part%'";          // Match Patient ID
        $conditions[] = "FirstName LIKE '%$part%'";          // Match First Name
        $conditions[] = "LastName LIKE '%$part%'";           // Match Last Name
        $conditions[] = "CONCAT(FirstName, ' ', LastName) LIKE '%$part%'"; // Match Full Name
        $conditions[] = "CONCAT(FirstName, ' ', MiddleInitial, ' ', LastName) LIKE '%$part%'"; // Match with Middle Initial
    }

    $searchQuery = " WHERE " . implode(" OR ", $conditions);
}
$query = "SELECT PatientID, FirstName, MiddleInitial, LastName, Sex FROM patients" . $searchQuery;
$result = $connection->query($query);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $fullName = $row['FirstName'] . " " . ($row['MiddleInitial'] ? $row['MiddleInitial'] . " " : "") . $row['LastName'];
                                        echo "<tr onclick=\"selectPatient('" . $row['PatientID'] . "', '" . $fullName . "')\">";
                                        echo "<td>" . $row['PatientID'] . "</td>";
                                        echo "<td>" . $row['FirstName'] . "</td>";
                                        echo "<td>" . $row['MiddleInitial'] . "</td>";
                                        echo "<td>" . $row['LastName'] . "</td>";
                                        echo "<td>" . $row['Sex'] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center'>No data found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
       <!-- Consultation Form -->
       <div class="col-md-6">
            <div id="consultation-form" class="card d-none">
                <div class="card-header bg-success text-white">
                    Consultation Form
                </div>
                <div class="card-body">
                    <form action="save_consultation.php" method="POST">
                        <input type="hidden" id="patient_id" name="patient_id">
                        <div class="form-group">
                            <label for="selected_patient">Selected Patient</label>
                            <input type="text" id="selected_patient" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="time_in">Time In</label>
                            <input type="time" id="time_in" name="time_in" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="subjective">Subjective</label>
                            <textarea id="subjective" name="subjective" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="objective">Objective</label>
                            <textarea id="objective" name="objective" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="assessment">Assessment</label>
                            <textarea id="assessment" name="assessment" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="plan">Plan</label>
                            <textarea id="plan" name="plan" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="plan_date">Plan Date</label>
                            <input type="date" id="plan_date" name="plan_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="time_out">Time Out</label>
                            <input type="time" id="time_out" name="time_out" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="saved_by">Saved By</label>
                            <input type="text" id="saved_by" name="saved_by" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Save Consultation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    function selectPatient(patientID, patientName) {
        document.getElementById('patient_id').value = patientID;
        document.getElementById('selected_patient').value = patientName;
        document.getElementById('consultation-form').classList.remove('d-none');
    }
</script>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
