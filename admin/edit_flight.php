<?php
session_start();
include "admin_db.php";
$username = $_SESSION['username'];
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
if(!isset($_GET['route_id'])){
    header("Location: dashboard.php");
    exit();
}
$route_id = $_GET['route_id'];
$sql = "SELECT * FROM routes WHERE route_id='$route_id'";
$result = $conn->query($sql);
if($result->num_rows == 0){
    echo "Invalid flight!";
    exit();
}
$route = $result->fetch_assoc();
if(isset($_POST['update'])){
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $departure = $_POST['departure_date'];
    $price = $_POST['price'];
    $total_seats = $_POST['total_seats'];
    $seats_booked = $route['total_seats'] - $route['seats_left'];
    $seats_left = $total_seats - $seats_booked;
    $updateSql = "UPDATE routes SET 
                    source='$source',
                    destination='$destination',
                    departure_date='$departure',
                    price='$price',
                    total_seats='$total_seats',
                    seats_left='$seats_left'
                  WHERE route_id='$route_id'";
    if($conn->query($updateSql)===TRUE){
        $success = "Flight updated successfully!";
        // refresh route data
        $result = $conn->query($sql);
        $route = $result->fetch_assoc();
    } else {
        $error = "Failed to update flight!";
    }
}
if(isset($_POST['delete'])){
    $deleteSql = "DELETE FROM routes WHERE route_id='$route_id'";
    if($conn->query($deleteSql) === TRUE){
        header("Location: dashboard.php?msg=Flight+Deleted");
        exit();
    } else {
        $error = "Failed to delete flight!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Flight</title>
    <style>
        body{
            background:#f4f6f8;
            font-family:Arial,sans-serif;
            display:flex;
            justify-content:center;
            padding:50px;
        }
        .edit-card{
            background:white;
            padding:40px;
            border-radius:16px;
            box-shadow:0 8px 20px rgba(0,0,0,0.15);
            width:500px;
        }
        h1{
            text-align:center;
            margin-bottom:30px;
            color:#333;
        }
        label{
            display:block;
            margin-top:15px;
            font-weight:bold;
            color:#555;
        }
        input, select{
            width:100%;
            padding:12px;
            margin-top:6px;
            border-radius:10px;
            border:1px solid #ccc;
            font-size:15px;
        }
        .btns{
            display:flex;
            justify-content:space-between;
            margin-top:30px;
        }
        .btn{
            padding:12px 20px;
            border:none;
            border-radius:10px;
            cursor:pointer;
            font-weight:bold;
            transition:0.3s;
            color:white;
        }
        .update{
            background:#28a745;
        }
        .update:hover{
            background:#218838;
        }
        .delete{
            background:#dc3545;
        }

        .delete:hover{
            background:#c82333;
        }

        .cancel{
            background:#dc3545;
            text-decoration:none;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .cancel:hover{
            background:#c82333;
        }

        .message{
            text-align:center;
            margin-top:20px;
            font-weight:bold;
        }

        .success{color:green;}
        .error{color:red;}
}
    </style>
</head>
<body>
<div class="edit-card">
    <h1>Edit Flight</h1>
    <?php if(isset($success)) echo "<div class='message success'>$success</div>"; ?>
    <?php if(isset($error)) echo "<div class='message error'>$error</div>"; ?>
    <form method="POST">
        <label>Source</label>
        <input type="text" name="source" value="<?php echo $route['source']; ?>" required>
        <label>Destination</label>
        <input type="text" name="destination" value="<?php echo $route['destination']; ?>" required>
        <label>Departure Date</label>
        <input type="date" name="departure_date" value="<?php echo $route['departure_date']; ?>" required>
        <label>Price (Rs)</label>
        <input type="number" name="price" value="<?php echo $route['price']; ?>" required>
        <label>Total Seats</label>
        <input type="number" name="total_seats" value="<?php echo $route['total_seats']; ?>" required>
        <div class="btns">
            <button type="submit" name="update" class="btn update">Update Flight</button>
            <button type="submit" name="delete" class="btn delete">Delete Flight</button>
            <a href="dashboard.php" class="btn cancel">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>