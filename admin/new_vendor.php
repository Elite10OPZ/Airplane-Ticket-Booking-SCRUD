<?php
session_start();
include "admin_db.php";
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


$username = $_SESSION['username'];


$sql = "SELECT * FROM routes ORDER BY departure_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>New Vendor</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body#sides {
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
 body#register {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }
        
        .login-container {
            background-color: #fdfefe;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 350px;
        }
        
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 24px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        input[type="submit"] {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s;
        }
        
        input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .note {
            margin-top: 25px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #667eea;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .note code {
            background-color: #e9ecef;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 10px;
            color: #667eea;
            font-size: 28px;
            font-weight: bold;
        }
.content {
    margin-left: 240px; 
    width: calc(100% - 240px);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

    </style>
</head>
<body id="sides">

<div class="sidebar">
    <h2>Admin</h2>
    <a href="dashboard.php" class="active">Dashboard</a>
    <a href="new_flight.php">Create New Flight</a>
    <a href="new_vendor.php">Create New Vendor</a>
    <a href="credits.php">Add Credits</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
</div>



<div class="content">
    <div class="login-container">
        <h2>Register New Vendor</h2>

        <form method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required placeholder="Enter your username">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Enter your password">
            </div>

            <input type="submit" name="submit" value="Register">
        </form>
    </div>
</div>

</body>


 <?php
if(isset($_POST['submit']))
{
    include "admin_db.php";
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $sql = "INSERT INTO admin values('$user', '$pass')";
    if($conn->query($sql)===TRUE)
    {
        ?>
        <html>
        <body>
            <script type="text/javascript">
                alert("User registration succesfull!");
            </script>
        </body>
        </html>
        <?php
       
    }
    else
    {
    if ($conn->errno == 1062) {
    ?>
        <html>
        <body>
            <script type="text/javascript">
                alert("Duplicate user");
            </script>
        </body>
        </html>
        <?php
    }
}
    
}
?>


</body>
</html>
