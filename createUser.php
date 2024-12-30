<?php

require_once("database/databaseLogin.php");

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

try {

    
    $query = "INSERT INTO `Customer`(`Email`, `Fname`, `Lname`, `Password`) VALUES (:email, :fname, :lname, :password)";
    $stmt = $pdo->prepare($query);
    
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':fname', $_POST['fname']);
    $stmt->bindParam(':lname', $_POST['lname']);
    $stmt->bindParam(':password', $_POST['password']);
    
    $stmt->execute();
    $variabl = "hi";
    

} catch (PDOException $e) {
    
    echo "Error: " . $e->getMessage();
}

header("Location: login.php");
exit();

