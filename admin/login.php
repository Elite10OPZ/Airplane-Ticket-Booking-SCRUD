<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }
        
        .login-container {
            background-color: white;
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
    </style>
</head>
<body>
    <div class="login-container">
       
        <h2>Login Admin Portal</h2>
        
      
        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required 
                       placeholder="Enter your username">
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required 
                       placeholder="Enter your password">
            </div>
            
            <input type="submit" name="submit" value="Login">
            <br><br>
        </form>
        
        
       
</body>
</html>
        <?php
if(isset($_POST['submit']))
{
    include "admin_db.php";
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $sql = "SELECT * FROM admin";
    $a=0;
    $result=$conn->query($sql);
    if($result->num_rows>0)
    {
        while($row=$result->fetch_assoc())
            {
                if($row['username']===$user)
                {
                 
                    if($row['password']===$pass)
                    {
                        $a=2;
                        break;
                    }
                    else
                    {
                        $a=1;
                        break;

                    }
                }
            else
            {
               
            }
            }
    }
    if($a==2)
    {
         session_start();               
        $_SESSION['username'] = $user;
       
        header("Location: dashboard.php");
        exit();
    }
    else if($a==1)
    {
    	?>
    	<html>
    	<body>
    		<script>
    			alert("Incorrect Password");
    		</script>
    	</body>
    	</html>
    	<?php
  
    }
    else
    {
    	?>
    	<html>
    	<body>
    		<script type="text/javascript">
    			alert("Invalid Username");
    		</script>
    	</body>
    	</html>
     <?php
    }
}
?>

