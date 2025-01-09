function getCart() {
    makeRequest(fetch('/cart/get', {
        method: 'GET',
    })).then((data) => {
        loadCartView(data);
    }).catch((error) => {
        redirect('/cart');
    });
}

function loadCartView(data) {
    const cart = document.getElementById('sec-cart');
    if (cart === null) {
        return;
    }
    cart.innerHTML = '';
    if (data.cart.length === 0) {
        window.location.href = '/cart';
    }
    Object.values(data.cart).forEach(item => {
        const itemElement = document.createElement('div');
        itemElement.innerHTML = `
            <div class="card cart">
                <header>
                    <div class="controls" id="controls-vinyl_${item.vinyl.id_vinyl}">
                        <button onclick="addToCart(${item.vinyl.id_vinyl}, 1)">
                            <i class="bi bi-caret-up-fill"></i>
                        </button>
                        <p id="quantity-vinyl_${item.vinyl.id_vinyl}">${item.quantity}</p>
                        <button onclick="addToCart(${item.vinyl.id_vinyl}, -1)">
                            <i class="bi bi-caret-down-fill"></i>
                        </button>
                    </div>
                </header>
                <div class="product-details">
                    <div>
                        <img src="/resources/img/albums/${item.vinyl.cover}" alt="album cover">
                    </div>
                    <div class="info">
                        <h3>${item.vinyl.title}</h3>
                        <p>${item.vinyl.artist_name} #${item.vinyl.genre}</p>
                        <p>${item.vinyl.type} - ${item.vinyl.rpm}rpm - ${item.vinyl.inch}"</p>
                    </div>
                </div>
                <footer>
                    <p>${item.vinyl.cost} €</p>
                </footer>
            </div>
        `;
        cart.appendChild(itemElement.firstElementChild);
        cart.appendChild(itemElement);
    });
    document.getElementById('btn-cart_submit').innerHTML = `Checkout - ${data.total} €`;
}