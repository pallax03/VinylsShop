<div class="coupon card" id="card-coupon_<?php echo $coupon['id_coupon']?>" 
    data-id="<?php echo $coupon['id_coupon']?>" data-discount_code="<?php echo $coupon['discount_code']?>" data-percentage="<?php echo $coupon['percentage'] * 100?>" data-valid_from="<?php echo $coupon['valid_from']?>" data-valid_until="<?php echo $coupon['valid_until']?>" > 
    <?php if(Session::isSuperUser() && isset($editable) && $editable==1):?> 
        <header>
            <a onclick="loadCoupon(<?php echo $coupon['id_coupon']?>)">
                <i class="bi bi-pencil-fill"></i>
            </a>
        </header>
    <?php endif; ?>
    <span class="coupon-details">
        <p><?php echo $coupon['discount_code']?>:</p>
        <p>
            <?php echo $coupon['percentage'] * 100?>% off (<?php echo $coupon['valid_from']?> - <?php echo $coupon['valid_until']?>)
        </p>
    </span>
    <?php if(Session::isSuperUser() && isset($editable) && $editable==1):?>
        <footer>
            <a class="delete" onclick="deleteCoupon(<?php echo $coupon['id_coupon']?>)">
                <i class="bi bi-trash"></i>
            </a>
        </footer>
    <?php endif; ?>
</div>