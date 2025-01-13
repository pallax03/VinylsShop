<section aria-labelledby="cart-info">
    <i class="bi bi-bag-fill"></i>
    <h1>Cart</h1>
</section>
<?php if (isset($cart) && count($cart) > 0): ?>
    <section id="sec-cart" class="cards">
        <?php
            foreach ($cart as $item) {
                include COMPONENTS . 'cards/cart.php';
            }
        ?>
    </section>
    <div class="large button">
        <i class="bi bi-credit-card-fill"></i>
        <button id="btn-cart_submit" onclick="redirect('/checkout')" >Checkout - <?php echo $total ?> €</button>
    </div>
<?php else: ?>
<section>    
    <div class="div"></div>
    <div class="container center vertical">
        <p>No vinyls in the cart!</p>
        <a href="/">Go to Shop!</a>
    </div>
</section>
<?php endif; ?>
<script src="/resources/js/cart.js"></script>