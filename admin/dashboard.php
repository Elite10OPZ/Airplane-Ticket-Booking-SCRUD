<?php
session_start();
include "admin_db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
//
$username = $_SESSION['username'];


$sql = "SELECT * FROM routes ORDER BY departure_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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

     
        .cards {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 6px solid #667eea;
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
            color: #333;
        }

        .info {
            color: #555;
            margin: 6px 0;
            font-size: 15px;
        }

        .status {
            font-size: 14px;
            font-weight: bold;
            margin-top: 8px;
        }

        .fast {
            color: #e67e22;
        }

        .full {
            color: red;
        }

        .book-btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 22px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .book-btn:hover {
            background: #5a67d8;
        }
        .search-box {
    background: white;
    padding: 20px;
    border-radius: 14px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    margin-bottom: 25px;
}

.search-box form {
    display: flex;
    gap: 15px;
    align-items: center;
}

.search-box input {
    flex: 1;
    padding: 12px 14px;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 15px;
}

.search-box input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102,126,234,0.15);
}

.search-box button {
    padding: 12px 22px;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.search-box button:hover {
    background: #5a67d8;
}
.status {
    padding: 6px 12px;
    border-radius: 12px;
    font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}

.status.green {
    background-color: #28a745; 
    color: white;
}

.status.yellow {
    background-color: #ffc107; 
    color: black;
}

.status.red {
    background-color: #dc3545; 
    color: white;
}


    </style>
</head>
<body>


<div class="sidebar">
    <h2>Admin</h2>
    <a href="dashboard.php" class="active">Dashboard</a>
    <a href="new_flight.php">Create New Flight</a>
    <a href="new_vendor.php">Create New Vendor</a>
    <a href="credits.php">Add Credits</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
</div>




<div class="main">

   <div class="header">
        <h1>Welcome, <?php echo htmlspecialchars($username); ?></h1>
        <p>Flights Details:Delete,Update and View</p>
    </div>
<div class="search-box">
    <form method="POST">
        <input type="text" name="from" placeholder="Search Flight By Destination" required>
        <button type="submit" name="submit">Search Flights</button>
    </form>
</div>

<?php

$sql = "SELECT * FROM routes ORDER BY departure_date ASC";


if (isset($_POST['submit'])) {

    $dest = mysqli_real_escape_string($conn, $_POST['from']);

    $sql = "SELECT * FROM routes 
            WHERE source LIKE '%$dest%' 
            OR destination LIKE '%$dest%'
            ORDER BY departure_date ASC";
}

$result = $conn->query($sql);
?>



    <div class="cards">

       <?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        if ($row['seats_left'] == 0) {
            $status = "<div class='status red'>Fully Booked</div>";
        } elseif ($row['seats_left'] <= 20) {
            $status = "<div class='status yellow'> Fast Filling</div>";
        } else {
            $status = "<div class='status green'> Tickets Available</div>";
        }
?>

        <div class="card">

            <div class="left">
                <div class="route">
                    ✈️ <?php echo $row['source']." → ".$row['destination']; ?>
                </div>

                <div class="info">📅 Departure: <?php echo date("d-m-Y", strtotime($row['departure_date'])); ?></div>
                <div class="info">💺 Seats Left: <?php echo $row['seats_left']; ?></div>
                <div class="info">💰 Price: Rs <?php echo $row['price']; ?></div>

                <?php echo $status; ?>
            </div>

            <div class="right">
                
                    <a href="edit_flight.php?route_id=<?php echo $row['route_id']; ?>" class="book-btn">
                        Edit Flight
                    </a>
                
                   </div>
        </div>

        <?php
            }
        } else {
            echo "<p>No flights available.</p>";
        }
        ?>

    </div>

</div>

</body>
</html>
