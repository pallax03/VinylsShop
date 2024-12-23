<?php if (Session::getUser()): ?>
    <section aria-labelledby="user-info">
        <i class="bi bi-person-fill"></i>
        <h2 id="user-mail"><?php echo $user['mail'] ?></h2>
        <p id="user-newsletter">Newsletter: <?php echo $user['newsletter'] ? 'Subscribed' : 'Not subscribed' ?></p>
        <a href="/logout">Logout</a>
        <button id="delete-account">Delete Account</button>
        <script src="/resources/js/user.js"></script>
    </section>
    <form aria-label="Defaults" id="form-user_defaults">
        <ul>
            <li>
                <label for="default_address">
                    <i class="bi bi-geo-alt-fill"></i>
                    Address:
                </label>
                <input type="text" id="input-default_address" value="<?php echo (isset($user['default_address']) && !empty($user['default_address'])) ? ( $user['street_number'] . ' - '. $user['city'] . ' (' . $user['postal_code'] .')' ) : 'no default address.' ?>" name="default_address" disabled />
                <a href="user/addresses"><i class="bi bi-caret-right-fill"></i></a>
            </li>
            <li>
                <label for="default_card">
                    <i class="bi bi-credit-card-fill"></i>
                    Card:
                </label>
                <input type="text" id="input-default_card" value="<?php echo (isset($user['default_card']) && !empty($user['default_card'])) ? ('**** **** **** ' . substr($user['card_number'], -4)) : ('Balance: '. $user['balance'] . ' €') ?>" name="default_card" disabled />
                <a href="/user/cards"><i class="bi bi-caret-right-fill"></i></a>
            </li>
        </ul>
    </form>
    <section class="cards">
        <?php
        if (isset($orders) && count($orders) > 0) {
            echo "<h1>Orders</h1>";
            foreach ($orders as $order) {
                include COMPONENTS . '/cards/order.php';
            }
        } else {
            echo "<h1>No orders found!</h1>";
        }
        ?>
    </section>
<?php else: ?>
    <?php include COMPONENTS . 'login.php' ?>
    <script src="/resources/js/auth.js"></script>
<?php endif; ?>