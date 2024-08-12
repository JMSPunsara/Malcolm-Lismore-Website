let cart = [];

function addToCart(name, price) {
    cart.push({ name, price });
    displayCart();
}

function displayCart() {
    const cartItems = document.getElementById('cart-items');
    cartItems.innerHTML = '';
    let totalPrice = 0;
    cart.forEach((item, index) => {
        const li = document.createElement('li');
        li.textContent = `${item.name} - $${item.price.toFixed(2)}`;
        cartItems.appendChild(li);
        totalPrice += item.price;
    });
    document.getElementById('total-price').textContent = `Total: $${totalPrice.toFixed(2)}`;
}

function openCheckout() {
    document.getElementById('checkout-modal').style.display = 'block';
}

function closeCheckout() {
    document.getElementById('checkout-modal').style.display = 'none';
}

function generateOrderId() {
    return 'ORDER-' + Math.floor(Math.random() * 1000000);
}

function submitCheckout() {
    const name = document.getElementById('name').value;
    const address = document.getElementById('address').value;
    const email = document.getElementById('email').value;
    const cardNumber = document.getElementById('card-number').value;
    const expiryDate = document.getElementById('expiry-date').value;
    const cardholderName = document.getElementById('cardholder-name').value;
    const cvv = document.getElementById('cvv').value;

    const orderId = generateOrderId();

    const orderDetails = {
        orderId,
        name,
        address,
        email,
        cardNumber,
        expiryDate,
        cardholderName,
        cvv,
        cart
    };

    fetch('/checkout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(orderDetails)
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        cart = [];
        displayCart();
        closeCheckout();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
