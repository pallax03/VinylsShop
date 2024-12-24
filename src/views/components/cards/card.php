<div class="credit card" id="card-card_<?php echo $card['id_card']?>">
    <header>
        <?php if($user['default_card'] == $card['id_card']): ?>
            <a class="stars" onclick="setDefaultCard(<?php echo ''?>)">
                <i class="bi bi-star-fill"></i>    
            </a>
        <?php else: ?>
            <a class="stars" onclick="setDefaultCard(<?php echo $card['id_card']?>)">
                <i class="bi bi-star"></i>
            </a>
        <?php endif; ?>
    </header>
    <span class="card-details">
        <p>
            **** **** **** <?php echo substr($card['card_number'], -4)?>
        </p>
    </span>
    <footer>
        <a class="delete" onclick="deleteCard(<?php echo $card['id_card']?>)">
            <i class="bi bi-trash"></i>
        </a>
    </footer>
</div>