<?php
session_start();
include "db_client.php";  

require('libs/fpdf.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

if (!isset($_GET['booking_id'])) {
    die("Booking ID is required");
}

$booking_id = intval($_GET['booking_id']);  // sanitize input

$sql = "
SELECT b.booking_id, b.booked_at, r.source, r.destination, r.departure_date, r.price
FROM bookings b
JOIN routes r ON b.route_id = r.route_id
WHERE b.username='$username' AND b.booking_id=$booking_id
";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("No ticket found!");
}

$ticket = $result->fetch_assoc();

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Flight Ticket',0,1,'C');
$pdf->Ln(10);

$pdf->SetFont('Arial','',12);
$pdf->Cell(50,10,'Booking ID:',0,0);
$pdf->Cell(0,10,$ticket['booking_id'],0,1);
$pdf->Cell(50,10,'Source:',0,0);
$pdf->Cell(0,10,$ticket['source'],0,1);

$pdf->Cell(50,10,'Destination:',0,0);
$pdf->Cell(0,10,$ticket['destination'],0,1);

$pdf->Cell(50,10,'Departure Date:',0,0);
$pdf->Cell(0,10,date("d-m-Y", strtotime($ticket['departure_date'])),0,1);

$pdf->Cell(50,10,'Price (Rs):',0,0);
$pdf->Cell(0,10,$ticket['price'],0,1);

$pdf->Cell(50,10,'Booked At:',0,0);
$pdf->Cell(0,10,date("d-m-Y H:i", strtotime($ticket['booked_at'])),0,1);

$pdf->Ln(20);
$pdf->Cell(0,10,'Thank you for booking with us!',0,1,'C');

// Output
$pdf->Output('I', 'Ticket_'.$ticket['booking_id'].'.pdf');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticket</title>
</head>
<body>

</body>
</html>