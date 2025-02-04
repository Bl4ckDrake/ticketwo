<?php
session_start();
if (isset($_POST['login'])) {
    // Login logic
    require_once './api/auth.php';
    $user = login($_POST['email'], $_POST['password']);

    if ($user != null) {
        $_SESSION['user'] = $user;
        header('Location: ./dashboard.php');
        die();
    } else {
        echo '<div class="alert alert-danger" role="alert">Invalid credentials</div>';
    }
}

if (isset($_POST['register'])) {
    // Register logic
    require_once './api/auth.php';

    $register = register($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['password']);

    if ($register != null) {
        echo '<div class="alert alert-success" role="alert">User registered successfully</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">An error occurred</div>';
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login/Register</title>
    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <!-- Tabs for Login and Register -->
                <ul class="nav nav-tabs mb-4" id="authTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link active"
                            id="login-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#login"
                            type="button"
                            role="tab"
                            aria-controls="login"
                            aria-selected="true">
                            Login
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="register-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#register"
                            type="button"
                            role="tab"
                            aria-controls="register"
                            aria-selected="false">
                            Register
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="authTabsContent">
                    <!-- Login Form -->
                    <div
                        class="tab-pane fade show active"
                        id="login"
                        role="tabpanel"
                        aria-labelledby="login-tab">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title text-center">Login</h3>
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <label for="loginEmail" class="form-label">Email address</label>
                                        <input
                                            name="email"
                                            type="email"
                                            class="form-control"
                                            id="loginEmail"
                                            placeholder="Enter your email" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="loginPassword" class="form-label">Password</label>
                                        <input
                                            name="password"
                                            type="password"
                                            class="form-control"
                                            id="loginPassword"
                                            placeholder="Enter your password" />
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            id="rememberMe" />
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    <div id="loginAlert"></div>
                                    <button
                                        name="login"
                                        id="loginSubmit"
                                        type="submit"
                                        class="btn btn-primary w-100">
                                        Login
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Register Form -->
                    <div
                        class="tab-pane fade"
                        id="register"
                        role="tabpanel"
                        aria-labelledby="register-tab">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title text-center">Register</h3>
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <label for="registerName" class="form-label">First Name</label>
                                        <input
                                            name="name"
                                            type="text"
                                            class="form-control"
                                            id="registerName"
                                            placeholder="Enter your first name" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="registerSurname" class="form-label">Last Name</label>
                                        <input
                                            name="surname"
                                            type="text"
                                            class="form-control"
                                            id="registerSurname"
                                            placeholder="Enter your last name" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="registerEmail" class="form-label">Email address</label>
                                        <input
                                            name="email"
                                            type="email"
                                            class="form-control"
                                            id="registerEmail"
                                            placeholder="Enter your email" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="registerPassword" class="form-label">Password</label>
                                        <input
                                            name="password"
                                            type="password"
                                            class="form-control"
                                            id="registerPassword"
                                            placeholder="Create a password" />
                                    </div>
                                    <div id="registerAlert"></div>
                                    <button
                                        name="register"
                                        id="registerSubmit"
                                        type="submit"
                                        class="btn btn-success w-100">
                                        Register
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>