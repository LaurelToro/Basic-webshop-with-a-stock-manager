<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Kurv</title>
    <script src="App/Actions/kurv.js?v=2" defer></script>
    <link rel="stylesheet" type="text/css"
    href="Assets/stylesheet.css">
</head>

<body>
    <section class="cart">
    <h2 id="cart-heading">Din kurv</h2>
    <ul id="cart-items"></ul>
    <button id="clear-cart" type="button">Tøm kurv</button>
    </section>
    <section class="checkout">
    <h2>Betaling</h2>
    <form method="post" action="DB\DB-con-new.php" id="checkout-form">
        <label for="fname">Fornavn:</label>
        <input type="text" id="fname" name="fname" required><br><br>
        <label for="lname">Efternavn:</label>
        <input type="text" id="lname" name="lname" required><br><br>
        <label for="address">Adresse:</label>
        <input type="text" id="address" name="address" required><br><br>
        <label for="nummer">Telefonnummer:</label>
        <input type="text" id="nummer" name="nummer" required><br><br>
        <input type="hidden" id="cart-data" name="cart">
        <button type="submit">Betal</button>
        </form>
</body>
</html>

<?php




