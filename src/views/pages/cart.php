<section aria-labelledby="cart-info">
    <i class="bi bi-bag-fill"></i>
    <h1>Cart</h1>
</section>
<?php if (isset($cart) && count($cart) > 0): ?>
    <section class="cards">
        <?php
            foreach ($cart as $vinyl) {
                include COMPONENTS . 'cards/cart.php';
            }
        ?>
    </section>
    
<? else: ?>
    <div class="div"></div>
    <div class="container center vertical">
        <h2>No vinyls in the cart!</h2>
        <a href="/">Go to Shop!</a>
    </div>
<? endif; ?>