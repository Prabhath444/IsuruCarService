<?php
require_once("../../database/databaseLogin.php");

session_start();

if (isset($_SESSION["email"]) && $_SESSION["password"] && $_SESSION['admin_id']) {
    
} else {
    header("Location: ../../login.php");
}

$vmodel = $_POST['vmodel'];
$vmake = $_POST['vmake'];
$rnumber = $_POST['rnumber'];
$rrate = $_POST['rrate'];
$type = $_POST['type'];
$year = $_POST['year'];
$description = $_POST['description'];

//saving image in the server
$uploadDir = "../../images/vehicles/";
$image = $_FILES['img'];

$fileName = basename($image['name']);
$fileTmpPath = $image['tmp_name'];
$fileSize = $image['size'];
$fileError = $image['error'];
$fileType = $image['type'];

$uniqueFileName = uniqid("vehicle_", true) . "." . pathinfo($fileName, PATHINFO_EXTENSION);



$imgDestination = $uploadDir . $uniqueFileName;

if (!move_uploaded_file($fileTmpPath, $imgDestination)) {
    die ("Error: Could not save the file.");
}

$imgDestinationDB = substr($imgDestination, 6);

try {
    $pdo = new PDO($attr, $user, $pass, $opts);

    $query = "INSERT INTO `vehicle` (`Model`, `Make`, `Registration_number`, `Rental_rate`, `Type`, `Year`, `Availability`, `description`, `image`) VALUES (:vmodel, :vmake, :rnumber, :rrate, :type, :year, 'Available', :description, :img);";
    $stmt = $pdo->prepare($query);


    $stmt->bindParam(':vmodel', $vmodel);
    $stmt->bindParam(':vmake', $vmake);
    $stmt->bindParam(':rnumber', $rnumber);
    $stmt->bindParam(':rrate', $rrate);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':img', $imgDestinationDB);

    $stmt->execute();

    echo "Rental record updated successfully";
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
