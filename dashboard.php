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
        require_once 'api/concerts.php';
        $concerts = getConcerts();

        if (!$concerts) {
            echo "<h1>No concerts available</h1>";
        }

        foreach ($concerts as $concert) {
            $row = $concert;
            include 'components/concert_card/ConcertCard.php';
        }
        ?>
    </main>
    <?php include 'components/concert_card/Footer.php'; ?>
</body>

</html>