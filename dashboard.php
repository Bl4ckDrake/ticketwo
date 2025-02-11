<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

?>

<html lang="en">

<head>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/index.css" />

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="d-flex flex-column justify-content-center align-items-center">
    <?php include 'components/concert_card/Header.php'; ?>

    <main
        class="row d-flex justify-content-center align-items-center w-100"
        id="concerts">
        <?php
        require_once('util/bookings.php');

        // Retrieve the userId from the $_SESSION['user']
        $userId = $_SESSION['user'];

        // Get the user bookings
        $bookings = getUserBookings($userId);

        // Process the query result
        if ($bookings) {
            $data = [];
            while ($row = $bookings->fetch_assoc()) {
                $data[] = $row;
            }
            if (empty($data)) {
                echo "No bookings found.";
            } else {
        ?>
                <div class="container">
                    <div class="row justify-content-center">
                        <?php foreach ($data as $booking) { ?>
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $booking['concert_name']; ?></h5>
                                        <p class="card-text"><?php echo $booking['date']; ?></p>
                                        <p class="card-text"><?php echo $booking['location']; ?></p>
                                        <p class="card-text"><?php echo $booking['quantity']; ?></p>
                                        <a href="ticket.php?id=<?php echo $booking['booking_id']; ?>" class="btn btn-primary">View Ticket</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "Error executing query: " . $conn->error;
        }
        ?>


    </main>
    <?php include 'components/concert_card/Footer.php'; ?>
</body>

</html>