<?php
require_once 'database/databaseLogin.php';
try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    $query = "SELECT * FROM vehicle";
    $result = $pdo->query($query);

    while ($row = $result->fetch()) {
        echo 'Registration Number: ' . htmlspecialchars($row['Registration_number']) . "<br>";
        echo 'Make: ' . htmlspecialchars($row['Make']) . "<br>";
        echo 'Model: ' . htmlspecialchars($row['Model']) . "<br>";
        echo 'Year: ' . htmlspecialchars($row['Year']) . "<br>";
        echo 'Type: ' . htmlspecialchars($row['Type']) . "<br>";
        echo 'Availability: ' . htmlspecialchars($row['Availability']) . "<br>";
        echo 'Rental Rate: ' . htmlspecialchars($row['Rental_rate']) . "<br><br>";
    }

    ?>
</body>

</html>