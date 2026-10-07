<?php
$host = 'localhost';
$database = 'webshop';
$username = 'root';
$password = '';

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$database;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $error) {
    error_log($error->getMessage());
    http_response_code(500);
    exit('Kunne ikke oprette forbindelse til databasen.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_orders'])) {

    $sentOrders = $_POST['sent'] ?? [];

    $ordersql = "UPDATE `Order-list`
                 SET `Afsendt` = 1
                 WHERE `Order-ID` = ?";

    $orderstmt = $conn->prepare($ordersql);


    $lagerSQL = "UPDATE `Bog`
                 SET `Antal` = `Antal` - ?
                 WHERE `ID` = ?";

    $lagerstmt = $conn->prepare($lagerSQL);


    foreach ($sentOrders as $orderID) {

        $booksSQL = "SELECT `Bog-ID`, `Antal`
                     FROM `Order-list`
                     WHERE `Order-ID` = ?";

        $bookstmt = $conn->prepare($booksSQL);
        $bookstmt->execute([$orderID]);

        $books = $bookstmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($books as $book) {

            $lagerstmt->execute([
                $book['Antal'],
                $book['Bog-ID']
            ]);
        }


        // Mark the order as sent
        $orderstmt->execute([$orderID]);
    }


    // Refresh the page so the sent orders disappear
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$bøger= $conn->query("SELECT * FROM `Bog` ORDER BY `Titel`")->fetchAll(PDO::FETCH_ASSOC);

$sql = "
    SELECT
        ol.`Order-ID`,
        ol.`Dato`,
        k.`Fornavn`,
        k.`Efternavn`,
        k.`Adresse`,
        GROUP_CONCAT(
            CONCAT(b.`Titel`, ' (', ol.`Antal`, ' stk.)')
            SEPARATOR ', '
        ) AS `Bøger`
    FROM `Order-list` AS ol
    LEFT JOIN `Kunder` AS k ON k.`Kunder-ID` = ol.`Kunde-ID`
    LEFT JOIN `Bog` AS b ON b.`ID` = ol.`Bog-ID`
    WHERE ol.`Afsendt` = 0
    GROUP BY
        ol.`Order-ID`,
        k.`Fornavn`,
        k.`Efternavn`,
        k.`Adresse`
    ORDER BY ol.`Order-ID` DESC
";

$orders = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <title>Alle ordrer</title>
    <link rel="stylesheet" text="text/css" href="stylesheet.css">
</head>
<body>
    <section class="ordrer-det">
        <div class="order-section">
            <h1>Alle ordrer</h1>
            <form method="POST">
                <table class="order-list">
                    <thead>
                        <tr>
                            <th>Order-ID</th>
                            <th>Dato</th>
                            <th>Kunde</th>
                            <th>Adresse</th>
                            <th>Bøger</th>
                            <th>Afsend</th>
                        </tr>
                    </thead>
                    <tbody class="order-list-body">
                        <?php foreach ($orders as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars((string) $row['Order-ID'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars((string) $row['Dato'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($row['Fornavn'] . ' ' . $row['Efternavn'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($row['Adresse'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($row['Bøger'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <input type="checkbox" name="sent[]" value="<?= htmlspecialchars((string) $row['Order-ID'], ENT_QUOTES, 'UTF-8') ?>">
                                    <label>Afsendt?</label>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" name="send_orders">Marker som afsendt</button>
        </form>
        </div>
        <div class="order-section">
            <h1>Lager</h1>
            <table class="lager-liste">
                <thead>
                    <tr>
                        <th>Bog-ID</th>
                        <th>Titel</th>
                        <th>Antal på lager</th>
                        <p>Bliver først fjernet fra lageret EFTER man har afsendt.</p>
                    </tr>
                </thead>
                <tbody class="lager-liste-body">
                    <?php foreach ($bøger as $bog):?>
                        <tr>
                            <td><?= htmlspecialchars((string) $bog['ID'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($bog['Titel'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="<?= (int) $bog['Antal'] <= 10 ? 'low-stock' : '' ?>">
                                <?= htmlspecialchars((string) $bog['Antal'], ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
</section>
</body>
</html>
