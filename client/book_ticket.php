<?php
session_start();
include "db_client.php"; // Database connection

// Only logged-in users
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];


if (!isset($_GET['route_id'])) {
    echo "<script>alert('No route selected!'); window.location.href='dashboard.php';</script>";
    exit();
}

$route_id = $_GET['route_id'];


$sql = "SELECT seats_left, total_seats, price, source, destination, departure_date FROM routes WHERE route_id = $route_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<script>alert('Route not found!'); window.location.href='dashboard.php';</script>";
    exit();
}

$route = $result->fetch_assoc();

if ($route['seats_left'] <= 0) {
    echo "<script>alert('No seats left for this route!'); window.location.href='dashboard.php';</script>";
    exit();
}


$update = "UPDATE routes SET seats_left = seats_left - 1 WHERE route_id = $route_id";
$conn->query($update);


$insert = "INSERT INTO bookings (username, route_id) VALUES ('$username', $route_id)";
if ($conn->query($insert) === TRUE) {
    // Step 4: Show confirmation
    $ticket_id = $conn->insert_id; // Get last inserted booking id
    $departure = date("d-m-Y", strtotime($route['departure_date']));
    $message = "Ticket booked successfully!\n\n".
               "Booking ID: $ticket_id\n".
               "User: $username\n".
               "Route: ".$route['source']." → ".$route['destination']."\n".
               "Departure Date: $departure\n".
               "Price: Rs ".$route['price'];

    echo "<script>alert(`$message`); window.location.href='dashboard.php';</script>";
} else {
    echo "<script>alert('Error booking ticket!'); window.location.href='dashboard.php';</script>";
}
?>
