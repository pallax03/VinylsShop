<?php if (Session::getUser()): ?>
    <section aria-labelledby="user-info">
        <i class="bi bi-person-fill"></i>
        <h1 id="user-mail"><?php echo $user['mail'] ?></h1>
        <p id="user-newsletter">Newsletter: <?php echo $user['newsletter'] ? 'Subscribed' : 'Not subscribed' ?></p>
        <a class="error" href="/logout">Logout</a>
    </section>
    <div class="div"></div>
    <form aria-label="Defaults" id="form-user_defaults">
        <h1>Defaults</h1>
        <ul>
            <li>
                <label for="default_address"><i class="bi bi-geo-alt-fill"></i>
                Address:</label>
                <input type="text" id="input-default_address" value="<?php echo (isset($user['default_address']) && !empty($user['default_address'])) ? ( $user['name'] . ' - '. $user['city'] . ' (' . $user['postal_code'] .')' ) : 'no default address.' ?>" name="default_address" disabled />
                <a href="user/addresses"><i class="bi bi-caret-right-fill"></i></a>
            </li>
            <li>
                <label for="default_card"><i class="bi bi-credit-card-fill"></i>
                Card:</label>
                <input type="text" id="input-default_card" value="<?php echo (isset($user['default_card']) && !empty($user['default_card'])) ? ('**** **** **** ' . substr($user['card_number'], -4)) : ('Balance: '. $user['balance'] . ' €') ?>" name="default_card" disabled />
                <a href="/user/cards"><i class="bi bi-caret-right-fill"></i></a>
            </li>
        </ul>
    </form>
    <div class="div"></div>
    <section class="cards">
        <?php
        if (isset($orders) && count($orders) > 0) {
            echo "<h3>Orders</h3>";
            foreach ($orders as $order) {
                include COMPONENTS . '/cards/order.php';
            }
        } else {
            echo "<h3>No orders found!</h3>";
        }
        ?>
    </section>
    <script src="/resources/js/user.js"></script>
<?php else: ?>
    <?php include COMPONENTS . 'login.php' ?>
    <script src="/resources/js/auth.js"></script>
<?php endif; ?>