<?php
session_start();
include "db_client.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];


$countSql = "SELECT COUNT(*) AS total FROM bookings WHERE username='$username'";
$countRes = $conn->query($countSql);
$count = $countRes->fetch_assoc()['total'];
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
    <title>My Profile</title>
    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, sans-serif;
        }

        body{
            background:#f2f4f7;
            display:flex;
        }

       
        .sidebar{
            width:230px;
            height:100vh;
            background:linear-gradient(180deg,#667eea,#764ba2);
            color:white;
            padding:30px 20px;
            position:fixed;
        }

        .sidebar h2{
            text-align:center;
            margin-bottom:40px;
        }

        .sidebar a{
            display:block;
            padding:12px;
            margin-bottom:10px;
            color:white;
            text-decoration:none;
            border-radius:6px;
        }

        .sidebar a.active,
        .sidebar a:hover{
            background:rgba(255,255,255,0.2);
        }

 
        .main{
            margin-left:230px;
            padding:50px 30px;
            width:calc(100% - 230px);
        }

      
        .profile-top{
            background:white;
            padding:40px;
            border-radius:20px;
            box-shadow:0 8px 25px rgba(0,0,0,0.15);
            display:flex;
            align-items:center;
            gap:40px;
        }

        .avatar img{
            width:140px;
            height:140px;
            border-radius:50%;
            border:4px solid #667eea;
        }

        .info h1{
            color:#333;
            font-size:28px;
        }

        .tickets-box{
            margin-left:auto;
            background:#667eea;
            color:white;
            padding:25px 40px;
            border-radius:18px;
            text-align:center;
        }

        .tickets-box h2{
            font-size:42px;
        }

        .tickets-box p{
            font-size:16px;
            margin-top:6px;
        }
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
    <a href="bookings.php">My Tickets</a>
    <a href="profile.php" class="active">Profile</a>
    <a href="logout.php">Logout</a>
</div>

<!-- Main -->
<div class="main">

    <!-- Profile Top -->
    <div class="profile-top">
        <div class="avatar">
            <img src="https://ui-avatars.com/api/?name=<?php echo $username; ?>&background=667eea&color=fff&size=200">
        </div>

        <div class="info">
            <h1><?php echo $username; ?></h1>
            <p>Welcome back ✨</p>
        </div>

        <div class="tickets-box">
            <h2><?php echo $count; ?></h2>
            <p>Tickets Booked</p>
        </div>
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

         

        </div>
        <?php
            }
        } else {
            echo "<div class='empty'>You haven’t booked any tickets yet.</div>";
        }
        ?>

    </div>


</div>

</body>
</html>
