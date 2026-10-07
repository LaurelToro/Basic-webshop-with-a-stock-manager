<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Webshop</title>
    <script src="Public/App/Actions/kurv.js?v=2" defer></script>
    <link rel="stylesheet" type="text/css"
    href="Public/Assets/stylesheet.css">

<body>
    <header>
            <h1>Velkommen til min webshop!</h1>
            <p>Læs min nye bog!</p>
    </header>
    <section class="books">
        <aside class="book_1">
        <img id="pic" src="Public/Assets/cover.jpg" alt="Cover"/>
        <h2>Bog 1</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dolor velit, congue non augue nec, venenatis ornare arcu. Nulla euismod rhoncus enim quis fermentum. Aliquam et justo in eros egestas placerat sed ornare diam. Ut venenatis, dui congue congue molestie, lectus ex aliquet nibh, eget ullamcorper eros libero a nibh. <br> 
            Ut eget sapien mauris. Etiam tincidunt ut ex ac pharetra. Phasellus gravida dignissim neque. Donec commodo nulla ipsum, nec tempus nunc consequat vel. Cras aliquam, turpis in scelerisque sagittis, leo risus facilisis mi, eu congue ante lacus blandit dui. Ut tortor arcu, scelerisque sit amet porttitor sit amet, vehicula ac dolor.<br>
             Proin ullamcorper id tellus vel tristique. Cras felis odio, tincidunt ut sollicitudin et, mollis id arcu. Aliquam vel suscipit nibh.</p>
             <button type="button" data-book-id="1">Køb</button>
        </aside>
        <aside class="book_2">
        <img id="pic" src="Public/Assets/cover.jpg" alt="Cover"/>
        <h2>Bog 2</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dolor velit, congue non augue nec, venenatis ornare arcu. Nulla euismod rhoncus enim quis fermentum. Aliquam et justo in eros egestas placerat sed ornare diam. Ut venenatis, dui congue congue molestie, lectus ex aliquet nibh, eget ullamcorper eros libero a nibh. <br> 
            Ut eget sapien mauris. Etiam tincidunt ut ex ac pharetra. Phasellus gravida dignissim neque. Donec commodo nulla ipsum, nec tempus nunc consequat vel. Cras aliquam, turpis in scelerisque sagittis, leo risus facilisis mi, eu congue ante lacus blandit dui. Ut tortor arcu, scelerisque sit amet porttitor sit amet, vehicula ac dolor.<br>
             Proin ullamcorper id tellus vel tristique. Cras felis odio, tincidunt ut sollicitudin et, mollis id arcu. Aliquam vel suscipit nibh.</p>
             <button type="button" data-book-id="2">Køb</button>
        </aside>
    </section>
    <section aria-labelledby="cart-heading">
    <h2 id="cart-heading">Din kurv</h2>
    <ul id="cart-items"></ul>
    <button id="clear-cart" type="button">Tøm kurv</button>
    <p><a href="Public/Kurv.php">Gå til betaling</a></p>
</section>
</body>

<footer>
    <p>Telefon: 12345678</p>
    <p>2026</p>
    <p>Send en mail: <a id="mail" href="mailto:bog@mail.dk">bog@mail.dk</a></p>
</footer>
