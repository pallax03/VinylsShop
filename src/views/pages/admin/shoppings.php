<form action="/shipping" method="post">
    <h2>Shipping Info</h2>
    <ul>
        <li>
            <label for="shipping_courier">Courier</label>
            <input type="text" name="shipping_courier" value="<? echo $_ENV['SHIPPING_COURIER']?>" id="input-shipping_courier">
        </li>
        <li class="split">
            <label for="shipping_cost">Cost</label>
            <input type="text" name="shipping_cost" value="<? echo $_ENV['SHIPPING_COST']?>" id="input-shipping_cost">
        </li>
        <li class="split">
            <label for="shipping_goal">Goal</label>
            <input type="text" name="shipping_goal" value="<? echo $_ENV['SHIPPING_GOAL']?>" id="input-shipping_goal">
        </li>
        <li>
            <div class="large button">
                <i class="bi bi-truck"></i>
                <input type="button" id="btn-shipping_submit" aria-label="Set Shipping" value="Set Shipping" />
            </div>
        </li>
    </ul>
</form>
<script>
    document.getElementById('btn-shipping_submit').addEventListener('click', function() {
        let form = document.querySelector('form');
        let formData = new FormData(form);
        fetch(form.action, {
            method: form.method,
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // NOTIFICATION
            redirect(window.location.href);
        })
        .catch(error => console.error(error));
    });
</script>
<div class="div"></div>
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
<form action="/coupon" id="form-coupon" method="post">
        <h2>Coupon</h2>
        <ul>
            <li>
                <label for="input-discount_code">Code</label>
                <input type="text" name="discount_code" id="input-discount_code" placeholder="EXAMPLE10" aria-required="true" />
            </li>
            <li>
                <label for="input-percentage">Percentage</label>
                <input type="text" name="percentage" id="input-percentage" placeholder="%" aria-required="true" />
            </li>
            <li class="split">
                <label for="input-valid_from">From:</label>
                <input type="date" name="valid_from" id="input-valid_from" value="<?php echo date('Y-m-d'); ?>" aria-required="true" />
            </li>
            <li class="split">
                <label for="input-valid_until">Until:</label>
                <input type="date" name="valid_until" id="input-valid_until" value="<?php echo date('Y-m-d', strtotime('+1 month')); ?>" aria-required="true" />
            </li>
            <li>
                <div class="large button">
                    <i class="bi bi-percent"></i>
                    <button type="submit" id="btn-coupon_submit" aria-label="Add Coupon">Add Coupon</button>
                </div>
            </li>
        </ul>
    </form>
<script src="/resources/js/coupon.js"></script>