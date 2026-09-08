<?php
$host = "localhost";
$sname = "root";
$spass = "";
$db = "server";
$conn = new mysqli($host, $sname, $spass, $db);
if($conn->connect_error)
{
	die("Connection error");
}
else
{
	
}
?>