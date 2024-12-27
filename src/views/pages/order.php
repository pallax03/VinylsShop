<?php
var_dump($order);
?>
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
    <ul class="table">
        <li>
            <p>Vinyls Total:</p>
            <p>
                <?php
                    $total = 0;
                    foreach ($order['vinyls'] as $vinyl) {
                        $total += $vinyl['price'];
                    }
                    echo $total;
                ?>€
            </p>
            <p>22% (incl. IVAs)</p>
        </li>
        <li>
            <p>Shipping fee:</p>
            <p><?php echo $order['shipment_cost'] ?></p>
            <p></p>
        </li>
        <?php if (isset($order['discount_code']) && $order['discount_code'] != null): ?>
            <li>
                <p>Discount Code:</p>
                <p>
                    <?php echo $order['discount_code'] ?>
                </p>
                <p>
                    <?php echo $order['discount_percentage'] * 100 ?>%
                </p>
            </li>
        <?php endif; ?>
    </ul>
    <div class="div"></div>
    <span>
        <p>Total: </p>
        <p><?php echo $order['total_cost'] ?>€</p>
    </span>
</section>
<div class="div"></div>
<section>
    <span>
        <h4><strong>Paid</strong> with:</h4>
        <p><?php echo (!$order['id_card']) ? substr($card['card_number'], -4) : 'Balance' ?></p>
    </span>
</section>
<!-- <script src="/resources/js/user.js"></script> -->