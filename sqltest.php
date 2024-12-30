<?php // sqltest.php
require_once 'database/databaseLogin.php';
try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
if (isset($_POST['delete']) && isset($_POST['Registration_number'])) {
    $Registration_number = get_post($pdo, 'Registration_number');
    $query = "DELETE FROM vehicle WHERE Registration_number = $Registration_number";
    $result = $pdo->query($query);
}

if (
    isset($_POST['Make']) &&
    isset($_POST['Model']) &&
    isset($_POST['Year']) &&
    isset($_POST['Rental_rate']) &&
    isset($_POST['Registration_number'])
) {

    $Rental_rate = get_post($pdo, 'Rental_rate');
    $Model = get_post($pdo, 'Model');
    $Make = get_post($pdo, 'Make');
    $Year = get_post($pdo, 'Year');
    $Registration_number = get_post($pdo, 'Registration_number');
    $Type = get_post($pdo, 'Type');
    $Availability = get_post($pdo, 'Availability');
    $owner = 1;


    $query = "INSERT INTO Vehicle (Model, Make, Registration_number, Rental_rate, Type, Year, Availability, Vehicle_owner_Owner_ID) VALUES"
     . "($Model, $Make, $Registration_number, $Rental_rate, $Type, $Year, $Availability, $owner)";
    $result = $pdo->query($query);
}


echo <<<_END
     <form action="sqltest.php" method="post"><pre>
     Registration Number <input type="text" name="Registration_number">
     Make <input type="text" name="Make">
     Model <input type="text" name="Model">
     Rental Rate <input type="text" name="Rental_rate">
     Year <input type="text" name="Year">
     Type <input type="text" name="Type">
     Availability <input type="text" name="Availability">
     <input type="submit" value="ADD RECORD">
     </pre></form>
    _END;
$query = "SELECT * FROM vehicle";
$result = $pdo->query($query);
while ($row = $result->fetch()) {
    $r0 = htmlspecialchars($row['Registration_number']);
    $r1 = htmlspecialchars($row['Make']);
    $r2 = htmlspecialchars($row['Model']);
    $r3 = htmlspecialchars($row['Year']);
    $r4 = htmlspecialchars($row['Rental_rate']);

    echo <<<_END
     <pre>
     Registration Number $r0
 Make $r1
 Model $r2
 Year $r3
 Rental Rate $r4
 </pre>
 <form action='sqltest.php' method='post'>
 <input type='hidden' name='delete' value='yes'>
 <input type='hidden' name='Registration_number' value='$r0'>
 <input type='submit' value='DELETE RECORD'></form>
_END;
}
function get_post($pdo, $var)
{
    return $pdo->quote($_POST[$var]);
}
