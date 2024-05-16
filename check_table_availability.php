<?php
// Include database connection
require "admin/includes/db.php";  // Adjust the path as per your project structure


// Check user authentication

// Retrieve date and time from AJAX request
$date_res = isset($_POST['date_res']) ? $_POST['date_res'] : null;
$time = isset($_POST['time']) ? $_POST['time'] : null;
$bookedTables = [];

if ($date_res && $time) {
    // Prepare SQL to fetch booked table IDs for given date and time
    $query = "SELECT table_id FROM reservation WHERE date_res = ? AND time = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ss", $date_res, $time);  // 'ss' specifies the data types 'string' for both parameters
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch results
    while ($row = $result->fetch_assoc()) {
        $bookedTables[] = $row['table_id'];
    }
    
    $stmt->close();
}

// Send back the response in JSON format
echo json_encode(['bookedTables' => $bookedTables]);
?>
