<?php
require_once("../database/databaseLogin.php");
session_start();

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if (isset($_SESSION["email"]) && isset($_SESSION["password"])) {
    $email = $_SESSION["email"];
    $password = $_SESSION["password"];
} else {
    header("Location: login.php");
    exit();
}





function updateDetail($column, $value)
{

    global $email;
    global $pdo;
    global $password;

    $query = "UPDATE `Customer` SET $column = :value WHERE Email = :email AND PASSWORD = :password";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':value', $value);

    $stmt->execute();

    $response[$column] = $value;
    
}

try {

    if (isset($_POST["email"])) {
        updateDetail('Email', $_POST['email']);
        $_SESSION['email'] = $_POST['email'];
    }
    
    if (isset($_POST["fname"])) {
        updateDetail('Fname', $_POST['fname']);
        $_SESSION['fname'] = $_POST['fname'];
    }
    if (isset($_POST["lname"])) {
        updateDetail('Lname', $_POST['lname']);
        $_SESSION['lname'] = $_POST['lname'];
    }
    if (isset($_POST["address"])) {
        updateDetail('Address', $_POST['address']);
        $_SESSION['address'] = $_POST['address'];
    }
    if (isset($_POST["lnumber"])) {
        updateDetail('License_number', $_POST['lnumber']);
        $_SESSION['lnumber'] = $_POST['lnumber'];
    }
    if (isset($_POST["pnumber"])) {
        updateDetail('Phone_number', $_POST['pnumber']);
        $_SESSION['pnumber'] = $_POST['pnumber'];
    }


    header('Content-Type: application/json');
    echo json_encode($response);

} catch (PDOException $e) {

    echo "Error: " . $e->getMessage();
} catch (Exception $e) {

    echo "Error: " . $e->getMessage();
}
