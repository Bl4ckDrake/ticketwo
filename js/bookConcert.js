var quantity = 0;
        document.getElementById("ticketQuantityDown").addEventListener('click', () => {
            if (quantity > 0) {
                quantity--;
            }

            console.log("porco putano");

            //document.getElementById("ticketQuantity").innerText = quantity;
        });



        document.getElementById("ticketQuantityUp").addEventListener('click', () => {
            if (quantity < 10) {
                quantity++;
            }

            //document.getElementById("ticketQuantity").innerText = quantity;
        });

        document.getElementById("bookTicket").addEventListener('click', function(e) {
            e.preventDefault();
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