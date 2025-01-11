<section>
    <?php if (isset($cards) && $cards !== []): ?>
        <h1>Cards</h1>
        <?php
            foreach ($cards as $card) {
                include COMPONENTS . '/cards/card.php';
            }
        ?>
    <?php else: ?>
        <h1>No cards found!</h1>
    <?php endif; ?>
</section>
<div class="div"></div>
<form action="/user/card" id="form-card" method="post" novalidate>
    <ul>
        <li>
            <label for="card_number">Number:</label>
            <input placeholder="1234567887654321" type="tel" inputmode="numeric" pattern="[0-9\s]{13,19}"
                autocomplete="cc-number" maxlength="19" id="input-card_number" name="card_number"
                aria-describedby="card-number-description" required />
        </li>
        <li class="split">
            <label for="card_exp">Exp:</label>
            <input type="text" id="input-card_exp" name="card_exp"
                inputmode="numeric" pattern="[0-9]{2}/[0-9]{2}" placeholder="MM/AA"
                aria-describedby="card-exp-description" autocomplete="cc-exp" required />
        </li>
        <li class="split">
            <label for="card_cvc">CVC:</label>
            <input placeholder="123" type="text" id="input-card_cvc" name="card_cvc"
                inputmode="numeric" pattern="[0-9]{3,4}" maxlength="4"
                aria-describedby="card-cvc-description" autocomplete="cc-csc" required />
        </li>
        <li>
            <div class="large button">
                <i class="bi bi-credit-card-fill"></i>
                <input type="button" id="btn-card_submit" value="Add Card" />
            </div>
        </li>
    </ul>
</form>
<script src="/resources/js/card.js"></script>