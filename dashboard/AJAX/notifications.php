<?php
require_once("../../database/databaseLogin.php");

session_start();

if (($_POST['id']) != -1) {
    
    try {
                $pdo = new PDO($attr, $user, $pass, $opts);
                $id = $_POST["id"];
        
                $query = "UPDATE `notification` n SET n.`status` = 'read' WHERE n.`ID` = :notiID;";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':notiID', $id);
                $stmt->execute();
        
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }

} 

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
    $cusID = $_SESSION["customer_id"];

    $query = "SELECT COUNT(*) AS `UnreadCount` FROM `notification` n WHERE n.`status`='not-read' AND n.`Customer_ID`=:cusID;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':cusID', $cusID);
    $stmt->execute();

    $notifications = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['UnreadNotifiCount'] = $notifications['UnreadCount'];

    echo($notifications['UnreadCount']);

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}









