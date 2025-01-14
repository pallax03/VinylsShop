<section>
    <?php if (isset($coupons) && $coupons !== []): ?>
        <h2>Coupons</h2>
        <?php
            foreach ($coupons as $coupon) {
                include COMPONENTS . '/cards/coupon.php';
            }
        ?>
    <?php else: ?>
        <h2>No coupons found!</h2>
    <?php endif; ?>
</section>