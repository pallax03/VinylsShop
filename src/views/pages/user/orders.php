<?php if (Session::isSuperUser()): ?>
    <section aria-labelledby="user-info">
        <i class="bi bi-person-fill"></i>
        <div class="container center vertical">
            <h4 id="user-mail"><?php echo $user['mail'] ?></h4>
        </div>
    </section>
    <div class="div"></div>
<?php endif; ?>

<section class="cards">
    <h2>Orders</h2>
    <?php
    if (isset($orders) && count($orders) > 0) {
        $n = 0;
        foreach ($orders as $order) {
            $n++;
            include COMPONENTS . 'cards/order.php';
        }
    } else {
        echo "<h3>No orders found!</h3>";
    }
    ?>
</section>
<script src="/resources/js/cards.js"></script>