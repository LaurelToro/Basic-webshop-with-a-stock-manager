const books = {
    "1": { title: "Bog 1" },
    "2": { title: "Bog 2" }
};

const cartStorageKey = "bookshop-cart";
const cartItems = document.querySelector("#cart-items");
const cartCount = document.querySelector("#cart-count");

function loadCart() {
    try {
        const savedCart = JSON.parse(localStorage.getItem(cartStorageKey) || "{}");

        return Object.fromEntries(
            Object.entries(savedCart).filter(([bookId, quantity]) =>
                books[bookId] &&
                Number.isInteger(quantity) &&
                quantity > 0
            )
        );
    } catch {
        return {};
    }
}

let cart = loadCart();

function saveAndRenderCart() {
    localStorage.setItem(cartStorageKey, JSON.stringify(cart));
    renderCart();
}

function renderCart() {
    cartItems.replaceChildren();

    let totalBooks = 0;

    for (const [bookId, quantity] of Object.entries(cart)) {
        const book = books[bookId];
        if (!book) continue;

        totalBooks += quantity;

        const item = document.createElement("li");
        const title = document.createElement("span");
        title.textContent = book.title;

        const quantityInput = document.createElement("input");
        quantityInput.type = "number";
        quantityInput.min = "1";
        quantityInput.step = "1";
        quantityInput.value = String(quantity);
        quantityInput.dataset.quantityBookId = bookId;
        quantityInput.setAttribute("aria-label", `Antal ${book.title}`);

        const removeButton = document.createElement("button");
        removeButton.type = "button";
        removeButton.dataset.removeBookId = bookId;
        removeButton.textContent = "Fjern";

        item.append(title, quantityInput, removeButton);
        cartItems.append(item);
    }

    if (totalBooks === 0) {
        const emptyMessage = document.createElement("li");
        emptyMessage.textContent = "Kurven er tom.";
        cartItems.append(emptyMessage);
    }

    if (cartCount) {
        cartCount.textContent = String(totalBooks);
    }
}

document.querySelectorAll("[data-book-id]").forEach((button) => {
    button.addEventListener("click", () => {
        const bookId = button.dataset.bookId;
        if (!books[bookId]) return;

        cart[bookId] = (cart[bookId] || 0) + 1;
        saveAndRenderCart();
    });
});

cartItems.addEventListener("change", (event) => {
    const input = event.target.closest("[data-quantity-book-id]");
    if (!input) return;

    const bookId = input.dataset.quantityBookId;
    const quantity = Number.parseInt(input.value, 10);

    if (Number.isInteger(quantity) && quantity > 0) {
        cart[bookId] = quantity;
    }

    saveAndRenderCart();
});

cartItems.addEventListener("click", (event) => {
    const button = event.target.closest("[data-remove-book-id]");
    if (!button) return;

    delete cart[button.dataset.removeBookId];
    saveAndRenderCart();
});

document.querySelector("#clear-cart").addEventListener("click", () => {
    cart = {};
    saveAndRenderCart();
});

renderCart();

const checkoutForm = document.querySelector("#checkout-form");

if (checkoutForm) {
    checkoutForm.addEventListener("submit", (event) => {
        const cartField = checkoutForm.elements.namedItem("cart");
        cartField.value = JSON.stringify(cart);

        if (Object.keys(cart).length === 0) {
            event.preventDefault();
            alert("Kurven er tom. Tilfoej en bog foer betaling.");
        }
    });
}