<?php
require_once("database/databaseLogin.php");
session_start();

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$query = "SELECT * FROM `vehicle`";
$stmt = $pdo->prepare($query);

$stmt->execute();
$nvme = "1tb";

$vehicle_table = $stmt->fetchAll();

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | Isuru Car Service</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="css/style.css" rel="stylesheet">


</head>

<body>
    <div class="container-fluid px-0">

        <div id="spinner" class="d-block bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-warning" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only"></span>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg fixed-top py-0">
            <div id="nav-container" class="container-fluid col-xl-9 bg-white py-2 my-0 px-0">
                <a class="navbar-brand pt-4 px-2" href="#">
                    <img src="images/logo.jpg" alt="Logo" width="80" height="80" class="rounded-circle">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto nav-item-container">
                        <li class="nav-item">
                            <a class="btn btn-warning" onclick="location.href='login.php'"><span>Dashboard</span></a>
                        </li>
                        <li class="nav-item">
                            <button class="btn btn-warning" onclick="scrollToVehicles()"><span>Vehicles</span></button>
                        </li>
                        <li class="nav-item">
                            <button class="btn btn-warning" type="submit" onclick="scrollToContactUs()"><span>About Us</span></button>
                        </li>

                        <li class="nav-item">
                            <button class="btn btn-warning" onclick="location.href='login.php'"><span>SignUp / Login</span></button>
                        </li>

                        <li class="nav-item row phone-num" onclick="scrollToContactUs()">
                            <div class="svg col-4 rounded-circle bg-warning p-0 d-flex justify-content-center align-items-center">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div class="col-8">
                                <div class="row">Need Help?</div>
                                <div class="row">0777259259</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="container-fluid col-xl-9 content px-0">

            <!---------------- CAROUSEL ----------------------->


            <div id="carouselExampleRide" class="carousel slide" data-bs-ride="true">

                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleRide" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleRide" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleRide" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <div class="carousel-inner rounded-5">
                    <div class="carousel-item active">
                        <img src="images/img7.jpg" class="d-block w-100 rounded-5" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>First slide label</h5>
                            <p>Some representative placeholder content for the first slide.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="images/img9.png" class="d-block w-100 rounded-5" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="images/img6.png" class="d-block w-100 rounded-5" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <!---------------- CAROUSEL end----------------------->

            <!---------------- FORM ------------------------------>
            <div class="container-fluid bg-warning rounded-bordr formbg  form1">
                <div class="row py-5 d-flex justify-content-around">
                    <div class="col col-12 col-sm-6 pt-3 py-4 px-5">
                        <h1 class="fw-bold">Experience the Road like never before</h1>
                        <p>Experience the road like never before with our premium car rental service. Choose from luxury sedans to rugged SUVs, all at competitive prices with flexible booking. Your perfect drive starts here – rent today and make every journey unforgettable! </p>
                        <button class="btn btn-dark" onclick="scrollToVehicles()"><span>View all cars</span></button>
                    </div>
                    <div class="col bg-white col-12 col-sm-4 rounded-sm-5 rounded-bordr p-4">
                        <form action="login.php" method="post">
                            <h2 class="text-center">Book your car</h2>
                            <div class="py-4">
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="rentaldate" placeholder="Rental date" name="post_rentaldate" required="required" />
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="returndate" placeholder="Return date" name="post_returndate" required="required" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark col-12"><span>Book Now</span></button>
                        </form>
                    </div>
                </div>
            </div>

            <!---------------- FORM end------------------------------>


            <!---------------- icons -------------------------------->
            <div class="container-fluid three-icons">
                <div class="row justify-content-center">
                    <!-- icon 1 -->
                    <div class="col text-center d-flex flex-column align-items-center">
                        <i class="bi bi-geo-alt" style="font-size: 3rem;"></i>
                        <div class="fw-bold">Availability</div>
                        <div>Available in Negombo</div>
                    </div>
                    <!-- Icon 2 -->
                    <div class="col text-center d-flex flex-column align-items-center">
                        <i class="bi bi-car-front" style="font-size: 3rem;"></i>
                        <div class="fw-bold">Comfort</div>
                        <div>Enjoy a smooth, comfortable ride with our car rentals</div>
                    </div>
                    <!-- icon 3 -->
                    <div class="col text-center d-flex flex-column align-items-center">
                        <i class="bi bi-wallet-fill" style="font-size: 3rem;"></i>
                        <div class="fw-bold">Savings</div>
                        <div>Lowest price</div>
                    </div>
                </div>
            </div>
            <!---------------- icons end----------------------------->

            <!------------Vehicles section start --------------->

            <div class="container-fluid form1 px-0 px-0 " id="vehicles">
                <div class="row gy-5 d-flex justify-content-around mx-0 ">

                    <!-- card  -->
                    <?php

                    foreach ($vehicle_table as $vehicle) {

                        $vehicle_img = $vehicle['image'];
                        $vehicle_name = $vehicle['Make'] . " " . $vehicle['Model'];
                        $vehicle_descr = $vehicle['description'];


                        echo <<< _END

                        <div class="card col-12 col-md-3 px-0" style="width: 18rem;">
                                <img src="$vehicle_img" class="card-img-top" alt="...">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-center">$vehicle_name</h5>
                                    <p class="card-text">$vehicle_descr</p>
                                    <button type="button" class="btn btn-warning col-12 mt-auto" onclick="window.location = 'dashboard/Bookings.php'" ><span><span>Book Now</span></span></button>
                                </div>
                            </div>
                        _END;
                    }

                    ?>
                </div>
            </div>
            <!------------ Vehicles section end----------->



            <!---------------- Fact in Numbers ------------------------------>
            <div class="container-fluid bg-warning rounded-bordr formbg form1">
                <div class="row py-5 d-flex justify-content-center align-items-center text-center">
                    <div class="row">
                        <h1 class="fw-bold">Experience the Road like never before</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil nam blanditiis at nesciunt iste cum excepturi labore tempora </p>
                    </div>

                    <div class="row d-flex justify-content-around align-items-center text-center">
                        <div class="col-5 col-lg-2 bg-white mt-4 rounded-4">
                            <div class="row mt-2">
                                <div class="col-6">
                                    <i class="bi bi-car-front bg-dark px-2 rounded" style="color: white; font-size: 2.5rem;"></i>
                                </div>
                                <div class="col-4 offset-1">
                                    <h5 class="fw-bold row">15+</h5>
                                    <p class="row">Cars</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-5 col-lg-2 bg-white mt-4 rounded-4">
                            <div class="row mt-2">
                                <div class="col-6">
                                    <i class="bi bi-person-heart bg-dark px-2 rounded" style="color: white; font-size: 2.5rem;"></i>
                                </div>
                                <div class="col-4 offset-1">
                                    <h5 class="fw-bold row">10k+</h5>
                                    <p class="row">Customers</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-5 col-lg-2 bg-white mt-4 rounded-4">
                            <div class="row mt-2">
                                <div class="col-6">
                                    <i class="bi bi-calendar4-week bg-dark px-2 rounded" style="color: white; font-size: 2.5rem;"></i>
                                </div>
                                <div class="col-4 offset-1">
                                    <h5 class="fw-bold row">15+</h5>
                                    <p class="row">Cars</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-5 col-lg-2 bg-white mt-4 rounded-4">
                            <div class="row mt-2">
                                <div class="col-6">
                                    <i class="bi bi-speedometer2 bg-dark px-2 rounded" style="color: white; font-size: 2.5rem;"></i>
                                </div>
                                <div class="col-4 offset-1">
                                    <h5 class="fw-bold row">200m+</h5>
                                    <p class="row">Miles</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!---------------- Facts in Numbers end------------------------------>


            <!---------------- footer ------------------------------------->
            <footer class="bg-white text-dark form1 pt-4 pb-4">
                <div class="container">
                    <div class="row d-flex">
                        <div class="col-md-4 align-items-center">
                            <div class="row pt-5">
                                <div class="col pt-4 d-flex align-items-center justify-content-center">
                                    <img src="images/logo.jpg" alt="Logo" width="120" height="120" class="rounded-circle">
                                </div>
                            </div>
                            <div class="row pt-5">

                                <h5 class="pt-4">About Us</h5>
                                <p>Drive with confidence trusted service, quality vehicles. Stay connected with us for the latest offers and updates!.</p>
                                <div class="row">
                                    <div class="col text-center "><i class="bi bi-facebook " style="font-size: 2rem;"></i></div>
                                    <div class="col text-center"><i class="bi bi-twitter-x" style="font-size: 2rem;"></i></div>
                                    <div class="col text-center"><i class="bi bi-instagram" style="font-size: 2rem;"></i></div>
                                    <div class="col text-center"><i class="bi bi-whatsapp" style="font-size: 2rem;"></i></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row pt-5">
                                <!-- icon 1 -->
                                <div class="col text-center d-flex flex-column align-items-center pt">
                                    <i class="bi bi-geo-alt" style="font-size: 2rem;"></i>
                                    <div class="fw-bold">Address</div>
                                    <div>318/5A, ST. Mary’s Road,Mahahunupitiya
                                        Negombo</div>
                                </div>
                                <!-- Icon 2 -->
                                <div class="col text-center d-flex flex-column align-items-center">
                                    <i class="bi bi-envelope-at" style="font-size: 2rem;"></i>
                                    <div class="fw-bold">Comfort</div>
                                    <div>Enjoy a smooth, comfortable ride with our car rentals</div>
                                </div>
                                <!-- icon 3 -->
                                <div class="col text-center d-flex flex-column align-items-center">
                                    <i class="bi bi-telephone" style="font-size: 2rem;"></i>
                                    <div class="fw-bold">Phone</div>
                                    <div>0777 259 259</div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-6 d-flex flex-column align-items-center">
                                    <h5>Useful Links</h5>
                                    <ul class="list-unstyled">
                                        <li><a href="#" class="text-dark">About Us</a></li>
                                        <li><a href="#" class="text-dark">Contact Us</a></li>
                                        <li><a href="#" class="text-dark">Gallery</a></li>
                                </div>
                                <div class="col-6 d-flex flex-column align-items-center">
                                    <h5>Vehicles</h5>
                                    <ul class="list-unstyled">
                                        <li><a href="#" class="text-dark">Sedan</a></li>
                                        <li><a href="#" class="text-dark">Cabriolet</a></li>
                                        <li><a href="#" class="text-dark">Pickup</a></li>
                                        <li><a href="#" class="text-dark">Minivan</a></li>
                                        <li><a href="#" class="text-dark">SUV</a></li>
                                </div>
                            </div>

                            </ul>
                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="col text-center">
                            <small>&copy; 2024 Isuru Car Service. All Rights Reserved.</small>
                        </div>
                    </div>
                </div>
            </footer>

            <!------------------- footer end------------------------------------->
        </div>


    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="JS/script.js"></script>
    

</body>

</html>