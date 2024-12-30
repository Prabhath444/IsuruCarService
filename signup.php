<?php
session_start();
if (isset($_SESSION["fname"]) && $_SESSION["email"]){
    header("Location: index.php");
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>

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
    <nav class="navbar navbar-expand-lg fixed-top py-0">
        <div id="nav-container" class="container-fluid col-md-10 bg-white py-2 my-0 px-0">
            <a class="navbar-brand pt-4 px-2" href="#">
                <img src="images/logo.jpg" alt="Logo" width="80" height="80" class="rounded-circle" onclick="location.href='index.php'">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center padding2 ">
        <div class="row w-100 d-flex justify-content-center align-items-center">
            <div class="col-12 col-md-10 bg-warning px-0 rounded-4">
                <div class="row w-100 h-100 g-0 d-flex justify-content-center align-items-stretch">
                    <!-- Image Container -->
                    <div class="col-12 col-md-6 order-md-2 loginImg mx-0 px-0 rounded-end-4"></div>
                    
                    <!-- Form Section -->
                    <div class="col-12 col-md-6 py-3 order-md-1 d-flex align-items-center justify-content-center ">
                        <form class="col-11 p-3" action="createUser.php" method="POST">
                            <div>
                                <h2>Create Account</h2>
                                <p class="form-text">Enter your details to create your account</p>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required ="required" >
                            </div>
                            <div class="mb-3">
                                <label for="fname" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="fname" name="fname" required ="required" >
                            </div>
                            <div class="mb-3">
                                <label for="lname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lname" name="lname" required ="required">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required ="required" >

                            <button type="submit" class="btn mt-3 btn-primary col-12"><span>Create Account</span></button>
                            <div class="mt-2">
                                <a href="login.php" class="form-text fw-bold link">Already have an account?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>