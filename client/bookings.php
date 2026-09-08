<?php
session_start();
include "db_client.php";
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];
$sql = "
SELECT 
    b.booking_id,
    b.booked_at,
    r.source,
    r.destination,
    r.departure_date,
    r.price
FROM bookings b
JOIN routes r ON b.route_id = r.route_id
WHERE b.username = '$username'
ORDER BY b.booked_at DESC
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Tickets</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f8;
            display: flex;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 240px;
            height: 100vh;
            background: linear-gradient(180deg, #667eea, #764ba2);
            color: white;
            padding: 30px 20px;
            position: fixed;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        .sidebar a {
            display: block;
            padding: 12px 15px;
            margin-bottom: 10px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255,255,255,0.2);
        }

        /* ===== MAIN ===== */
        .main {
            margin-left: 240px;
            width: calc(100% - 240px);
            padding: 30px;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }

        .header h1 {
            color: #333;
        }

        /* ===== TICKETS ===== */
        .tickets {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .ticket {
            background: white;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 6px solid #28a745;
        }

        .left {
            width: 70%;
        }

        .right {
            width: 30%;
            text-align: right;
        }

        .route {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .info {
            color: #555;
            margin: 6px 0;
        }

        .badge {
            display: inline-block;
            margin-top: 8px;
            padding: 4px 10px;
            background: #28a745;
            color: white;
            border-radius: 12px;
            font-size: 13px;
        }

        .download-btn {
            background: #667eea;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .download-btn:hover {
            background: #5a67d8;
        }

        .empty {
            background: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            color: #666;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h2>✈️ SkyBook</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="bookings.php" class="active">My Tickets</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
</div>
<div class="main">
    <div class="header">
        <h1>My Tickets</h1>
        <p>All your booked flights</p>
    </div>
    <div class="tickets">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
        <div class="ticket">
            <div class="left">
                <div class="route">
                    ✈️ <?php echo $row['source']." → ".$row['destination']; ?>
                </div>
                <div class="info">📅 Departure: <?php echo date("d-m-Y", strtotime($row['departure_date'])); ?></div>
                <div class="info">🎫 Booking ID: <?php echo $row['booking_id']; ?></div>
                <div class="info">💰 Price: Rs <?php echo $row['price']; ?></div>
                <div class="info">🕒 Booked At: <?php echo date("d-m-Y H:i", strtotime($row['booked_at'])); ?></div>
                <span class="badge">Confirmed</span>
            </div>

            <div class="right">
                <a href="download_pdf.php?booking_id=<?php echo $row['booking_id']; ?>" class="download-btn">Download</a>
            </div>
        </div>
        <?php
            }
        } else {
            echo "<div class='empty'>You haven’t booked any tickets yet.</div>";
        }
        ?> </div>
</div>
</body>
</html>
