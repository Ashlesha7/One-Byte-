<?php
require "admin/includes/db.php";
session_start();

// Retrieve user ID from session or set it manually
$user_id = $_SESSION['user_id'];
$id = $_GET['id'];



if(isset($_GET['cancel'])) {
    $reserve_id = preg_replace("#[^0-9]#", "", $_GET['cancel']);
    $db->query("UPDATE reservation SET status='rejected', message='I have Cancel My Reservation due to my busy schedule.' WHERE reserve_id='".$id."'");
    // You might want to add notification logic here or redirect to a confirmation page.
// Similarly, add notification logic here or handle redirection.
// $update_reserve = $db->query("UPDATE reservation SET status='accepted' WHERE reserve_id='".$reserve_id."'");
// // Execute a SELECT query to get the user_id after the update
// $reserve_data = $db->query("SELECT user_id FROM reservation WHERE reserve_id = $reserve_id");

// // Check if the SELECT query was successful
// if ($reserve_data) {
// 	// Fetch the user_id from the result
// 	$row = $reserve_data->fetch_assoc();
// 	$user_id = $row['user_id'];
// 	$db->query("INSERT INTO notifications(user_id, message, seen) VALUES('".$user_id."', 'Your Reservation is successfully accepted', '1')");
// }
}

// Optionally mark notifications as seen if needed, or handle it via another API call
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification </title>
    <link rel="stylesheet" href="css/main.css" />
    <style>
        body {
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f0f0f0;
}

.container {
    text-align: center;
}

.reservation-box {
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 20px;
    max-width: 400px;
    margin: 0 auto;
}

.info {
    margin-bottom: 10px;
}

.label {
    font-weight: bold;
}

.cancel-btn {
    background-color: #ff6666;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px;
}

.cancel-btn:hover {
    background-color: #ff4d4d;
}

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<?php require "includes/header.php"; ?>

<div class="content">

<div class="container">
    <div class="reservation-box">
    <?php foreach ($notifications as $reservation): ?>
    <?php if ($reservation["id"] == $id): ?>
        <div class="container">
            <div class="reservation-box">
                <div class="info">
                    <div class="label">Message:</div>
                    <div class="value"><?php echo $reservation['message']; ?></div>
                </div>
                <div class="info">
                    <div class="label">Date:</div>
                    <div class="value"><?php echo isset($reservation['date_res']) ? $reservation['date_res'] : 'Not available'; ?></div>
                </div>
                <div class="info">
                    <div class="label">Status:</div>
                    <div class="value"><?php echo isset($reservation['status']) ? $reservation['status'] : 'Not available'; ?></div>
                </div>
                <?php if ($reservation['status'] == 'accepted'): ?>
                    <a href='notifications.php?cancel=<?php echo $reservation['id']; ?>&id=<?php echo $reservation['id']; ?>'><button class="cancel-btn">Cancel</button></a>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <!-- Handle the case where reservation ID doesn't match -->
    <?php endif; ?>
<?php endforeach; ?>

    </div>
</div>

</div>


</body>
</html>