<!DOCTYPE html>
<html>

<head>
    <title>Concert Ticket</title>
</head>

<body>
    <h1>Concert Ticket</h1>

    <?php
    // Generate a random ticket number
    $ticketNumber = uniqid();

    // Fake URL for the QR code
    $url = "https://example.com/tickets/{$ticketNumber}";

    // Generate the QR code image URL
    $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($url);
    ?>

    <h2>Ticket Number: <?php echo $ticketNumber; ?></h2>

    <img src="<?php echo $qrCodeUrl; ?>" alt="QR Code">
</body>

</html>