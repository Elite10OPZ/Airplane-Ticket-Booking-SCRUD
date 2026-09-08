<?php
session_start();
include "admin_db.php";
$username = $_SESSION['username'];
$success = "";
$error   = "";
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
if(isset($_POST['create']))
{
    include "admin_db.php";
$source = $_POST['source'];
$dest = $_POST['destination'];
$date = $_POST['departure_date'];
$price = $_POST['price'];
$seat = $_POST['total_seats'];
$create = "INSERT INTO routes(source, destination, departure_date, total_seats, seats_left, price) VALUES('$source', '$dest', '$date', $seat, $seat, $price)";
if($conn->query($create)===TRUE)
{
    $success = "Flight Created Sucesfully!";
}
  else {
        $error = "Failed to update flight!";
    }
}
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

        .create{
            background:#28a745;
        }

        .create:hover{
            background:#218838;
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


    </style>
</head>
<body>
    <div class="edit-card">
 <?php
  if($success != "")
   { ?>
        <div class="message success">
            <?php echo $success; 
        ?></div>
    <?php 
} ?>
    <?php if($error != "")
     { ?>
        <div class="message error"><?php echo $error; ?></div>
    <?php } 
    ?>

    <form method="POST">
        <label>Source</label>
        <input type="text" name="source" value="" required>

        <label>Destination</label>
        <input type="text" name="destination" value="" required>

        <label>Departure Date</label>
        <input type="date" name="departure_date" value="" required>

        <label>Price (Rs)</label>
        <input type="number" name="price" value="" required>

        <label>Total Seats</label>
        <input type="number" name="total_seats" value="" required>

        <div class="btns">
            <button type="submit" name="create" class="btn create">Create Flight</button>
            
            <a href="dashboard.php" class="btn cancel">Cancel</a>
        </div>

    </form>
</div>
</div>
</body>
</html>
