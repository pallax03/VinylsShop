<div class="address card" id="card-address_<?php echo $address['id_address']?>">
    <header>
        <?php if($user['default_address'] == $address['id_address']): ?>
            <a class="stars" onclick="setDefaultAddress(<?php echo ''?>)">
                <i class="bi bi-star-fill"></i>    
            </a>
        <?php else: ?>
            <a class="stars" onclick="setDefaultAddress(<?php echo $address['id_address']?>)">
                <i class="bi bi-star"></i>
            </a>
        <?php endif; ?>
    </header>
    <span class="address-details">
        <h4><?php echo $address['name']?>:</h4>
        <p>
            <?php echo $address['street_number']?> - <?php echo $address['city']?> (<?php echo $address['postal_code']?>)
        </p>
    </span>
    <footer>
        <a class="delete" onclick="deleteAddress(<?php echo $address['id_address']?>)">
            <i class="bi bi-trash"></i>
        </a>
    </footer>
</div>