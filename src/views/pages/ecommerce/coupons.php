<section>
    <?php if (isset($coupons) && $coupons !== []): ?>
        <h1>Coupons</h1>
        <?php
            foreach ($coupons as $coupon) {
                include COMPONENTS . '/cards/coupon.php';
            }
        ?>
    <?php else: ?>
        <h1>No coupons found!</h1>
    <?php endif; ?>
</section>