<?php
session_start();
?>

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
        require_once './util/concerts.php';

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
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button id="ticketQuantityDown" type="button" class="btn btn-primary">-</button>
                                    <button type="button" id="ticketQuantity" class="btn btn-primary">0</button>
                                    <button id="ticketQuantityUp" type="button" class="btn btn-primary">+</button>
                                </div>
                            </div>
                            <input type="hidden" name="concertId" value="<?php echo $concertId; ?>">
                            <button type="button" class="btn btn-primary" id="bookTicket" disabled>Book Tickets</button>
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
        var quantity = 0;
        document.getElementById("ticketQuantityDown").addEventListener('click', () => {
            if (quantity > 0) {
                quantity--;
            }

            if (quantity === 0) {
                document.getElementById("bookTicket").disabled = true;
            } else {
                document.getElementById("bookTicket").disabled = false;
            }

            document.getElementById("ticketQuantity").innerText = quantity;
        });



        document.getElementById("ticketQuantityUp").addEventListener('click', () => {
            if (quantity < 10) {
                quantity++;
            }

            document.getElementById("bookTicket").disabled = false;

            document.getElementById("ticketQuantity").innerText = quantity;
        });

        document.getElementById("bookTicket").addEventListener('click', function(e) {
            e.preventDefault();
            var ticketQuantity = document.getElementById("ticketQuantity").innerText;
            var concertId = "<?php echo $_GET['id']; ?>";
            var userId = "<?php echo $_SESSION['user']; ?>";

            var xhr = new XMLHttpRequest();
            xhr.open('POST', `http://localhost:3000/api/book.php?quantity=${ticketQuantity}&concert_id=${concertId}&user_id=${userId}`, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    // Handle the response here
                    window.location.href = `./ticket.php?id=${response.booking_id}`;
                }
            };
            xhr.send(JSON.stringify({
                concertId: concertId,
                ticketQuantity: ticketQuantity,
            }));


        });
    </script>
</body>


</html>