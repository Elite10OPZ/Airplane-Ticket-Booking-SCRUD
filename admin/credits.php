<?php
session_start();
include "admin_db.php";

$username = $_SESSION['username'];

$sql = "SELECT * FROM user";

if (isset($_POST['submit'])) {
    $dest = mysqli_real_escape_string($conn, $_POST['from']);
    $sql = "SELECT * FROM user 
            WHERE username LIKE '%$dest%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Credit</title>
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

        .balance {
            color: #28a745;
            font-weight: bold;
            font-size: 18px;
            margin-top: 8px;
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


    </style>
</head>
<body>


<div class="sidebar">
    <h2>Admin</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="new_flight.php">Create New Flight</a>
    <a href="new_vendor.php">Create New Vendor</a>
    <a href="credits.php" class="active">Add Credits</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">

   <div class="header">
        <h1>Welcome, <?php echo htmlspecialchars($username); ?></h1>
        <p>Manage User Wallet Balance</p>
    </div>
    
<div class="search-box">
    <form method="POST">
        <input type="text" name="from" placeholder="Search Users" required>
        <button type="submit" name="submit">Search</button>
    </form>
</div>

    <div class="cards">
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
        ?>
        <div class="card">
            <div class="left">
                <div class="route">
                    User Details
                </div>
               
                <div class="info">Username: <?php echo htmlspecialchars($row['username']); ?></div>
                <div class="balance">Wallet Balance: $<?php echo htmlspecialchars($row['wallet_balance']); ?></div>
            </div>

            <div class="right">
                <a href="edit_credit.php?user_id=<?php echo $row['id']; ?>" class="book-btn">
                    Update Balance
                </a>
            </div>
        </div>
        <?php 
            }
        } else {
            echo '<div class="card"><div class="left"><div class="info">No users found</div></div></div>';
        }
        ?>
    </div>

</div>

</body>
</html>