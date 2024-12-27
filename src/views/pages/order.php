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
    if (isset($vinyls) && count($vinyls) > 0) {
        foreach ($vinyls as $vinyl) {
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
            <p></p>
            <p></p>
            <p></p>
        </li>
        <li>
            <p></p>
            <p></p>
            <p></p>
        </li>
        <li>
            <p></p>
            <p></p>
            <p></p>
        </li>
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
        <p><?php echo $order['']; ?></p>
    </span>
</section>
<!-- <script src="/resources/js/user.js"></script> -->