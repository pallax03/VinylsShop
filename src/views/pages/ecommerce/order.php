<section aria-labelledby="user-info">
    <i class="bi bi-box-seam-fill"></i>
    <h1>#<?php echo $order['tracking_number'] ?></h1>
    <span>
        <p><?php echo $order['order_date'] ?></p>
        <p><?php echo $order['order_status'] ?></p>
    </span>
</section>
<section class="cards">
    <?php
    if (isset($order['vinyls']) && count($order['vinyls']) > 0) {
        foreach ($order['vinyls'] as $vinyl) {
            include COMPONENTS . 'cards/orderedvinyls.php';
        }
    } else {
        echo "<h3>No vinyls found!</h3>";
    }
    ?>
</section>
<section>
    <div class="container table">
        <p class="th">Vinyls Total:</p>
        <p>
            <?php
                $vinyl_total = 0;
                foreach ($order['vinyls'] as $vinyl) {
                    $vinyl_total += ($vinyl['cost'] * $vinyl['quantity']);
                }
                echo round($vinyl_total, 2);
            ?>
            €
        </p>
        <p>22% (incl. IVAs)</p>
    </div>
    <div class="container table">
        <p class="th">Shipping fee:</p>
        <p><?php echo round($order['shipment_cost'], 2) ?> €</p>
        <p></p>
    </div>
    <?php if (isset($order['discount_code']) && $order['discount_code'] != null): ?>
        <div class="container table">
            <p class="th">Discount Code:</p>
            <p>
                -
                <?php 
                    $vinyl_total += $order['shipment_cost'];
                    echo round($vinyl_total * $order['discount_percentage'], 2);
                ?>
                €
            </p>
            <p>
                <?php echo round($order['discount_percentage'] * 100, 2) ?>%
            </p>
        </div>
    <?php endif; ?>
    <div class="div"></div>
    <div class="container inline center space-between">
        <p>Total: </p>
        <p><?php echo round($order['total_cost'], 2) ?>€</p>
    </div>
</section>
<div class="div"></div>
<section class="padding-1">
    <div class="container inline center space-between">
        <h4><b>Paid</b> with:</h4>
        <p>
            <?php echo (isset($order['id_card']) && $order['id_card'] != null) ? ('**** **** **** ' .substr($order['card_number'], -4)) : 'Balance' ?>
        </p>
    </div>
</section>
<!-- <script src="/resources/js/user.js"></script> -->