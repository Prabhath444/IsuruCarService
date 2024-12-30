<?php
session_start();

if (isset($_POST['post_rentaldate']) && $_POST['post_returndate']) {

    $_SESSION['post_rentaldate'] = $_POST['post_rentaldate'];
    $_SESSION['post_returndate'] = $_POST['post_returndate'];
}

if (isset($_SESSION["fname"]) && $_SESSION["email"] && isset($_POST['post_rentaldate']) && $_POST['post_returndate']) {
    header("Location: dashboard/Bookings.php");
    exit();
}

if (isset($_SESSION["fname"]) && $_SESSION["email"]) {
    header("Location: dashboard/index.php");
    exit();
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top py-0 navbar-light bg-light">
        <div id="nav-container" class="container-fluid col-md-10 bg-white py-2 my-0 px-0">
            <a class="navbar-brand pt-4 px-2" href="#">
                <img src="images/logo.jpg" alt="Logo" width="80" height="80" class="rounded-circle" onclick="location.href='index.php'">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center padding">
        <div class="row w-100 d-flex justify-content-center align-items-center rounded-4">
            <div class="col-12 col-md-10 bg-warning px-0 login-bg rounded-4">
                <div class="row w-100 h-100 g-0 d-flex justify-content-center align-items-stretch rounded-4">
                    <div class="col-12 col-md-6 order-md-2 loginImg mx-0 px-0 rounded-end-4">
                    </div>
                    <div class="col-12 col-md-6 order-md-1 rounded-start-4">
                        <div class="g-0 row w-100 h-100 d-flex justify-content-center align-items-center bg-warning rounded-start-4">
                            <form class="col-11 col-md-9 py-3" method="POST" action="authenticate.php" autocomplete="on">
                                <div>
                                    <h2>Welcome</h2>
                                    <p class="form-text">Enter your login credentials to access your account</p>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                                </div>
                                <div class="form-check form-switch mb-2">
                                <label class="form-check-label" for="is_admin">Login as an admin</label>
                                <input class="form-check-input" type="checkbox" role="switch" name="is_admin" value="true">
                                </div>
                                <button type="submit" class="btn btn-primary col-12"><span>Login</span></button>
                                <div class="row mt-2">
                                    <a href="signup.php" class="form-text fw-bold link">Don't have an account?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
