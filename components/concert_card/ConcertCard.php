<div class="col-sm-6 mb-3">
    <div class="card">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="./<?php echo $row['image_url'] ?>" class="img-fluid rounded-start" alt="<?php echo $row['concert_name'] ?>">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['concert_name'] ?></h5>
                    <p class="card-text"><?php echo $row['location'] ?> <?php echo $row['date'] ?></p>
                    <p class="card-text"><small class="text-body-secondary">Available Tickets: <?php echo $row['available_tickets'] ?></small></p>
                    <p class="card-text"><small class="text-body-secondary"><?php echo $row['band_name'] ?></small></p>
                    <a href="./concert_page.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">Book Now</a>
                </div>
            </div>
        </div>
    </div>
</div>