<?php
session_start();
include "admin_db.php";

$username = $_SESSION['username'];

/* Count total flights */
$countSql = "SELECT COUNT(*) AS total FROM routes";
$countRes = $conn->query($countSql);
$count = $countRes->fetch_assoc()['total'];

/* Get all flights */
$sql = "
SELECT 
    route_id,
    source,
    destination,
    departure_date,
    price
FROM routes
ORDER BY route_id DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Profile</title>
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
            margin-bottom:40px;
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

        .info p{
            color:#666;
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

        .tickets{
            display:flex;
            flex-direction:column;
            gap:20px;
        }

        .ticket{
            background:white;
            padding:25px;
            border-radius:16px;
            box-shadow:0 6px 18px rgba(0,0,0,0.15);
            border-left:6px solid #667eea;
        }

        .route{
            font-size:20px;
            font-weight:bold;
            margin-bottom:10px;
        }

        .meta{
            color:#555;
            margin:6px 0;
        }

        .empty{
            background:white;
            padding:30px;
            border-radius:12px;
            text-align:center;
            color:#666;
            box-shadow:0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="new_flight.php">Create New Flight</a>
    <a href="new_vendor.php">Create New Vendor</a>
    <a href="profile.php" class="active">Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">

    <div class="profile-top">
        <div class="avatar">
            <img src="https://ui-avatars.com/api/?name=<?php echo $username; ?>&background=667eea&color=fff&size=200">
        </div>

        <div class="info">
            <h1><?php echo $username; ?></h1>
            <p>Administrator Panel </p>
        </div>

        <div class="tickets-box">
            <h2><?php echo $count; ?></h2>
            <p>Flights Created</p>
        </div>
    </div>

    <div class="tickets">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
        <div class="ticket">
            <div class="route">
                ✈️ <?php echo $row['source']." → ".$row['destination']; ?>
            </div>

            <div class="meta">📅 Departure: <?php echo date("d-m-Y", strtotime($row['departure_date'])); ?></div>
            <div class="meta">🆔 Route ID: <?php echo $row['route_id']; ?></div>
            <div class="meta">💰 Price: Rs <?php echo $row['price']; ?></div>

        </div>
        <?php
            }
        } else {
            echo "<div class='empty'>No flights created yet</div>";
        }
        ?>
    </div>

</div>

</body>
</html>
