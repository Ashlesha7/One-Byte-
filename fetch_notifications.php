<?php
session_start();
require "admin/includes/db.php";

// $user_id = $_SESSION['user_id']; // make sure user_id is stored in session upon login

$user_id = $_SESSION['user_id'];
$sql = "SELECT message FROM notifications WHERE user_id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row['message'];
    // Optionally mark as seen
    $db->query("UPDATE notifications SET seen = 1 WHERE notification_id = " . $row['notification_id']);
}

echo json_encode($notifications);

?>