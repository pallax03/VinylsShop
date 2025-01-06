<section>
    <?php if (isset($coupons) && $coupons !== []): ?>
        <h1>Coupons</h1>
        <?php
            foreach ($coupons as $coupon) {
                include COMPONENTS . '/cards/coupon.php';
            }
        ?>
    <? else: ?>
        <h1>No coupons found!</h1>
    <? endif; ?>
</section>
<div class="div"></div>
<form action="/coupon" id="form-coupon" method="post" novalidate>
    <h2>Coupon</h2>
    <ul>
        <li>
            <label for="discount_code">Code</label>
            <input type="text" name="discount_code" id="input-discount_code">
        </li>
        <li>
            <label for="percentage">Percentage</label>
            <input type="text" value="20%" name="percentage" id="input-percentage">
        </li>
        <li class="split">
            <label for="valid_from">From:</label>
            <input type="date" name="valid_from" id="input-valid_from" value="<?php echo date('Y-m-d'); ?>">
        </li>
        <li class="split">
            <label for="valid_until">Until:</label>
            <input type="date" name="valid_until" id="input-valid_until" value="<?php echo date('Y-m-d', strtotime('+1 month')); ?>">
        </li>
        <li>
            <div class="large button">
                <i class="bi bi-percent"></i>
                <input type="button" id="btn-coupon_submit" aria-label="Add Coupon" value="Add Coupon" />
            </div>
        </li>
    </ul>
</form>
<form action="/user/address" id="form-address" method="post" novalidate>
    <ul>
        <li>
            <label for="address_name">Name:</label>
            <input autocomplete="name" type="text" id="input-address_name" name="address_name" placeholder="Full name" required aria-required="true" aria-label="Name" />
        </li>
        <li>
            <label for="address_street">Street & Number:</label>
            <input autocomplete="street-address" type="text" id="input-address_street" name="address_street" placeholder="Via Example, 123" required aria-required="true" aria-label="Street and number" />
        </li>
        <li class="split">
            <label for="address_city">City:</label>
            <input autocomplete="address-level2" type="text" id="input-address_city" name="address_city" placeholder="City" required aria-required="true" aria-label="City" />
        </li>
        <li class="split">
        <label for="address_cap">CAP:</label>
        <input autocomplete="postal-code" type="text" id="input-address_cap" name="address_cap" placeholder="CAP" pattern="[0-9]{5}" required aria-required="true" aria-label="CAP" />
        </li>
        <li>
            <div class="large button">
                <i class="bi bi-geo-alt-fill"></i>
                <input type="button" id="btn-address_submit" aria-label="Add Address" value="Add Address" />
            </div>
        </li>
    </ul>
</form>
<script src="/resources/js/coupon.js"></script>