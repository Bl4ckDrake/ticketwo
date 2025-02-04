<?php
session_start();
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary w-100">
    <div class="container-fluid">
        <a class="navbar-brand" href="./index.php">TickeTwo</a>

        <form class="d-flex collapse" role="search" method="POST" action="./index.php">
            <input
                value="<?php echo $_POST['search'] ?>"
                name="search"
                class="form-control me-2"
                type="search"
                placeholder="Cerca per nome, artista o band"
                aria-label="Search" />
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav ms-auto my-2 my-lg-0">
                <?php
                if (isset($_SESSION['user'])) {
                ?>
                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./dashboard.php">Dashboard</a></li>
                            <li><a class="dropdown-item" href="./favourites.php">Favourites</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <a class="dropdown-item" href="./logout.php">Logout</a>
                            </li>
                        </ul>
                    </li>
                <?php
                } else {
                ?>
                    <li class="nav-item">
                        <a href="./login.php" class="btn btn-primary">Login</a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>