<?php
require_once("../../database/databaseLogin.php");

session_start();


try {
    $pdo = new PDO($attr, $user, $pass, $opts);
    $query = "SELECT r.*, v.Model,v.Make,v.Rental_rate, c.Email FROM `rental` r JOIN `vehicle` v ON r.`Vehicle_Registration_number` = v.`Registration_number` JOIN `customer` c ON r.`Customer_ID` = c.`Customer_ID` ORDER BY `Time` DESC;";


    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $rental_vehicle = $stmt->fetchAll();

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$selected_status = $_POST['status'];


foreach ($rental_vehicle as $row) {
    static $no = 0;
    $no++;
    $status = $row['Rental_status'];

    if ($status != $selected_status) {
        $no--;
        continue;
    }

    $vehicle_name = $row['Make'] . " " . $row['Model'];
    $total_KM = $row['Total_KM'];
    $rental_date = $row['Rental_date'];
    $return_date = $row['Return_date'];
    $rental_rate = $row['Rental_rate'];
    $date = date('Y-m-d', strtotime($row['Time']));
    $cusEmail = $row['Email'];
    $rentID = $row['Rental_ID'];


    $rentalDateTime = new DateTime($rental_date);
    $returnDateTime = new DateTime($return_date);

    $interval = $rentalDateTime->diff($returnDateTime);
    $days = $interval->days;

    if ($days * 100 - $total_KM > 0) {
        $amount = $days * 100 * $rental_rate;
    } else {
        $amount = $total_KM * $rental_rate;
    }

    if($status == "Ongoing"){
        $settlePaymentButton = <<< _END
        <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#settlePayment" onclick="settlePayment($rentID)" ><span>Settle Payment</span></button></td>
        _END;
        $amount = "Pending";

    }else{
        $settlePaymentButton = "";
    }
    

    echo <<< _END
    
        <tr class="text-center">
            <th scope="row">$no</th>
            <td>$vehicle_name</td>
            <td scope="col">$date</td>
            <td>$cusEmail</td>
            <td>$amount</td>
            $settlePaymentButton
        </tr>
        _END;
}
