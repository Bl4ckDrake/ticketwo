<!DOCTYPE html>
<html>

<head>
    <title>Concert Page</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/index.css" />

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include 'components/concert_card/Header.php'; ?>
    <main class="row d-flex justify-content-center align-items-center w-100">
        <?php
        // Include the concerts.php file
        require_once './api/concerts.php';

        // Get the concert ID from the URL
        $concertId = $_GET['id'];

        // Get the concert details using the getConcert method
        $concert = getConcert($concertId);

        // Check if the concert exists
        if ($concert) {
        ?>
            <div class="container d-flex justify-content-center align-items-center">
                <div class="card" style="width: 18rem;">
                    <img src="./<?php echo $concert['image_url']; ?>" class="card-img-top" alt="Concert Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $concert['name']; ?></h5>
                        <p class="card-text">Date: <?php echo $concert['date']; ?></p>
                        <p class="card-text">Location: <?php echo $concert['location']; ?></p>

                        <form>
                            <div class="form-group">
                                <label for="ticketQuantity">Number of Tickets:</label>
                                <input type="number" class="form-control" id="ticketQuantity" name="ticketQuantity" min="1" max="10" required>
                            </div>
                            <input type="hidden" name="concertId" value="<?php echo $concertId; ?>">
                            <button type="button" class="btn btn-primary">Book Tickets</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php
        } else {
            echo 'Concert not found.';
        }
        ?>
    </main>

    <?php include 'components/concert_card/Footer.php'; ?>

    <script>
        document.querySelector('button').addEventListener('click', function() {
            <?php
            if (!isset($_SESSION['user_id'])) {
                echo 'window.location.href = "./login.php";return;';
                exit;
            }
            ?>

            var ticketQuantity = document.querySelector('#ticketQuantity').value;
            var concertId = document.querySelector('input[name="concertId"]').value;
            var userId = <?php echo $_SESSION['user_id']; ?>;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', `http://localhost:8000/api/book?quantity=${ticketQuantity}&concert_id=${concertId}&user_id=${userId}`, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    // Handle the response here
                }
            };
            xhr.send(JSON.stringify({
                concertId: concertId,
                ticketQuantity: ticketQuantity,
            }));

            window.location.href = `./checkout.php?concertId=${concertId}&ticketQuantity=${ticketQuantity}`;
        });
    </script>
</body>

</html>