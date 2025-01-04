<?php 
    $is_paying_with_card = isset($user['default_card']) && !empty($user['default_card']);
?>
<form aria-label="Defaults" id="form-order_info">
    <h1>Checkout</h1>
    
    <ul>
        <li>
            <label for="default_address">
                <i class="bi bi-geo-alt-fill"></i>
                Address:
            </label>
            <input type="text" id="input-default_address" value="<?php echo (isset($user['default_address']) && !empty($user['default_address'])) ? ($user['name'] . ' - ' . $user['city'] . ' (' . $user['postal_code'] . ')') : 'no default address.' ?>" name="default_address" disabled />
            <a href="user/addresses"><i class="bi bi-caret-right-fill"></i></a>
        </li>
        <li>
            <label for="default_card">
                <i class="bi bi-credit-card-fill"></i>
                Card:
            </label>
            <input type="text" id="input-default_card" value="<?php echo ($is_paying_with_card) ? ('**** **** **** ' . substr($user['card_number'], -4)) : ('Balance: ' . $user['balance'] . ' €') ?>" name="default_card" disabled />
            <a href="/user/cards"><i class="bi bi-caret-right-fill"></i></a>
        </li>
        <li>
            <label for="discount_code">
                <i class="bi bi-percent"></i>
                Discount Code:
            </label>
            <input type="text" id="input-discount_code" value="" name="discount_code"/>
        </li>
        <li>
            <label for="shipping_notes">
                <i class="bi bi-pencil-square"></i>
                Shipping Notes:
            </label>
            <input type="text" id="textarea-shipping_notes" name="shipping_notes"/>
        </li>
    </ul>
</form>
<div class="div"></div>
<section id="sec-cart" class="cards">
    <h2>Cart</h2>
    <?php
    foreach ($cart as $item) {
        $vinyl = $item['vinyl'];
        $vinyl['quantity'] = $item['quantity'];
        include COMPONENTS . 'cards/orderedvinyls.php';
    }
    ?>
</section>
<section>
    <div class="container table">
        <p class="th">Vinyls Total:</p>
        <p>
            <?php
                $vinyl_total = 0;
                foreach ($cart as $item) {
                    $vinyl_total += ($item['vinyl']['cost'] * $item['quantity']);
                }
                echo round($vinyl_total, 2);
            ?>
            €
        </p>
        <p>22% (incl. IVAs)</p>
    </div>
    <div class="container table">
        <p class="th">Shipping fee:</p>
        <p><?php echo round($shipping['cost'], 2) ?> €</p>
        <p><?php echo $shipping['courier'] ?></p>
    </div>
    <div class="container table">
        <p class="th">Discount Code:</p>
        <p id="p-discount_difference">-- €</p>
        <p id="p-discount_percentage">-- %</p>
    </div>
    <div class="div"></div>
    <div class="container inline center space-between">
        <p>Total: </p>
        <p id="p-checkout_total"><?php echo round($total, 2) ?>€</p>
    </div>
</section>
<section class="no-margin no-padding">
    <div class="large button">
        <? if($is_paying_with_card): ?>
            <i class="bi bi-credit-card-fill"></i>
        <? else: ?>
            <i class="bi bi-cash"></i>
        <? endif; ?>
        <button class="container inline center" id="btn-checkout_submit">
            <p>
                Pay with <?php echo ($is_paying_with_card) ? ('**** ' . substr($user['card_number'], -4)) : ('Balance: ' . $user['balance'] . ' €') ?>
            </p>
            <p> - </p>
            <p id="p-checkout_submit"><?php echo $total ?> €</p>
        </button>
    </div>
</section>
<script src="/resources/js/checkout.js"></script>