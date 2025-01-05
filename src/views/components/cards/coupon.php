<div class="coupon card" id="card-coupon_<?php echo $coupon['id_coupon']?>">
    <header>
        <a onclick="updateCoupon(<?php echo $coupon['id_coupon']?>)">
            <i class="bi bi-pencil-fill"></i>
        </a>
    </header>
    <span class="coupon-details">
        <h4><?php echo $coupon['discount_code']?>:</h4>
        <p>
            <?php echo $coupon['percentage'] * 100?>% off (<?php echo $coupon['valid_from']?> - <?php echo $coupon['valid_until']?>)
        </p>
    </span>
    <footer>
        <a class="delete" onclick="deleteCoupon(<?php echo $coupon['id_coupon']?>)">
            <i class="bi bi-trash"></i>
        </a>
    </footer>
</div>