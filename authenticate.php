<?php

require_once("database/databaseLogin.php");

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $is_admin = $_POST["is_admin"];
} else {
    header("Location: login.php");
    exit();
}



try {
    if ($is_admin) {
        $query = "SELECT * FROM `admin` WHERE Email = :email AND Password = :password";
    } else {
        $query = "SELECT * FROM customer WHERE Email = :email AND Password = :password";
    }


    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);

    $stmt->execute();

    $row = $stmt->fetch();

    //............notification count
    $cusID = $row['Customer_ID'];

    $query2 = "SELECT COUNT(*) AS `UnreadCount` FROM `notification` n WHERE n.`status`='not-read' AND n.`Customer_ID`=:cusID;";
    $stmt2 = $pdo->prepare($query2);
    $stmt2->bindParam(':cusID', $cusID);
    $stmt2->execute();

    $notifications = $stmt2->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // If a user is found, redirect to index.php
        session_start();
        if ($is_admin) {
            $_SESSION['admin_id'] = $row['Admin_ID'];
            $_SESSION['email'] = $row['Email'];
            $_SESSION['name'] = $row['Name'];
            $_SESSION['password'] = $row['Password'];

            header("Location: admin/index.php");
        } else {

            $_SESSION['fname'] = $row['Fname'];
            $_SESSION['email'] = $row['Email'];
            $_SESSION['password'] = $row['Password'];
            $_SESSION['lname'] = $row['Lname'];
            $_SESSION['customer_id'] = $row['Customer_ID'];
            $_SESSION['lnumber'] = $row['License_number'];
            $_SESSION['pnumber'] = $row['Phone_number'];
            $_SESSION['address'] = $row['Address'];
            
            $_SESSION['UnreadNotifiCount'] = $notifications['UnreadCount'];

            header("Location: dashboard/index.php");
        }
        exit();
    } else {
        // If no user is found, redirect to login.php
        header("Location: login.php?error=invalid_credentials");
        exit();
    }
} catch (PDOException $e) {

    echo "Error: " . $e->getMessage();
}
