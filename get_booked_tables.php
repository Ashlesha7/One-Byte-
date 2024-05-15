<?php
session_start();
require "admin/includes/db.php";


// Check user authentication

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}
$user_id = $_SESSION['user_id'];

// Fetch notifications from the database
$query = $db->prepare("SELECT * FROM notifications WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$notifications = [];

while ($row = $result->fetch_assoc()) {
    $notifications[] = [
        'id' => $row['notification_id'],
        'message' => $row['message']
    ];
}

$date_res = $_POST['date_res'];
$time = $_POST['time'];
$bookedTables = [];

if ($date_res && $time) {
    $startTime = date('H:i:s', strtotime($time . ' -3 hours'));
    $endTime = date('H:i:s', strtotime($time . ' +3 hours'));
    $reservedTables = $db->query("SELECT table_id FROM reservation WHERE date_res = '$date_res' AND (time BETWEEN '$startTime' AND '$endTime')");

    while ($row = $reservedTables->fetch_assoc()) {
        $bookedTables[] = $row['table_id'];
    }
}

echo json_encode(['bookedTables' => $bookedTables]);
?>
