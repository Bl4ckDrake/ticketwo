<?php
// Check if the user variable is present in the session
session_start();
if (!isset($_SESSION['user'])) {
    // Redirect the user to a login page or another appropriate page
    header("Location: login.php");
    exit;
}

// Retrieve the booking by ID
$bookingId = $_GET['id']; // Assuming the ID is passed as a query parameter
?>

<!DOCTYPE html>
<html>

<head>
    <title>Concert Ticket</title>
    <link rel="stylesheet" href="css/reset.css" />

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <h1>Concert Ticket</h1>

    <?php
    // Include the bookings utility file
    require_once 'util/bookings.php';

    // Fake URL for the QR code
    $url = "http://localhost:3000/ticket.php?{$bookingId}";

    // Generate the QR code image URL
    $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($url);

    $booking = getBookingById($bookingId);

    $booking = $booking->fetch_assoc();

    // Display the booking details
    if ($booking) {
    ?>
        <div class="card" style="width: 70%; margin: 0 auto;">
            <div class="row g-0">
                <div class="col-md-8 d-flex align-items-center">
                    <div class="card-body text-start">
                        <h5 class="card-title"><?php echo $booking['concert_name']; ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo $booking['date']; ?></h6>
                        <p class="card-text"><?php echo $booking['location']; ?></p>
                        <p class="card-text"><?php echo $booking['quantity']; ?></p>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center">
                    <img src="<?php echo $qrCodeUrl; ?>" alt="QR Code" style="width: 50%;">
                </div>
            </div>
        </div>

        <button class="btn btn-primary" onclick="window.print()">Print</button>
    <?php
    } else {
        echo "<p>Booking not found.</p>";
    }
    ?>
</body>

</html>