<?php
// Include your database connection file
include_once("config.php");

// Check if the faculty parameter is set
if (isset($_GET['faculty'])) {
    // Get the selected faculty value
    $faculty = $_GET['faculty'];

    // Prepare and execute a query to fetch related semesters based on the selected faculty
    $sql = "SELECT semester FROM all_semester WHERE faculty = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $faculty);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch and store the semesters in an array
    $semesters = [];
    while ($row = $result->fetch_assoc()) {
        $semesters[] = $row['semester'];
    }

    // Send the semesters as JSON response
    echo json_encode($semesters);
} else {
    // Return an empty array if the faculty parameter is not set
    echo json_encode([]);
}
?>
