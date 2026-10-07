<?php

$host = "localhost";
$db = "webshop";
$user = "root";
$password = "";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit("Ugyldig forespørgsel.");
}

$Kurv = json_decode($_POST["cart"], true);

if (empty($Kurv)){
    exit("Kurven er tom");
}

try {
    $conn = new PDO(
    "mysql:host=$host;dbname=$db;charset=utf8mb4",
    $user,
    $password
    );

    $conn-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO `kunder` (`Fornavn`,`Efternavn`,`Adresse`,`Nummer`)
    VALUES (?, ?, ?, ?)";

    $stmt = $conn ->prepare($sql);
    $stmt->execute([
        $_POST["fname"],
        $_POST["lname"],
        $_POST["address"],
        $_POST["nummer"],
    ]);

    $kundeID = $conn->lastInsertId();

    $sql = "INSERT INTO `ordrer` (`Kunde-ID`,`Dato`)
        VALUES (?, NOW())";

        $stmt = $conn ->prepare($sql);
        $stmt -> execute([$kundeID]);

        $orderID = $conn ->lastInsertId();

    $sql = "INSERT INTO `order-list` (`Kunde-ID`,`Bog-ID`,`Antal`,`Dato`,`Order-ID`)
        VALUES (?,?,?, NOW(),?)";
        $stmt= $conn ->prepare($sql);

        foreach ($Kurv as $BogID=>$antal){
            $stmt ->execute([
                $kundeID,
                $BogID,
                $antal,
                $orderID
            ]);
        }

    echo("Ordren er gemt! Kundenummer: ". $kundeID);
    echo("Du bliver videresendt om 5 sekunder.");
}catch (PDOException $e) {
    echo "Der skete en fejl: " . $e->getMessage();
}
header('Refresh: 5; url=../../index.php');