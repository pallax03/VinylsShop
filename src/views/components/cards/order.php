<div class="flip">
    <div class="order card active">
        <header>
            <span><?php echo $n ?></span>
            <a href="/order?id_order=<?php echo $order['id_order'] ?>">
                <i class="bi bi-box-seam-fill"></i>
                <h2><? echo $order['order_status']?></h2>
            </a>
        </header>
        <div class="order-details">
            <ul>
                <?php foreach (array_slice($order['vinyls'], 0, 3) as $vinyl): ?>
                    <li>
                        <a href="/vinyl?id_vinyl=<?php echo $vinyl['id_vinyl'] ?>"">
                            <img src="/resources/img/albums/<? echo $vinyl['album_cover']?>" alt="album cover">
                            <h6><? echo $vinyl['album_title']?></h6>
                            <p><? echo $vinyl['price']?> €</p>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <footer>
            <button class="btn-specular">
                <i class="bi bi-truck"></i>
                <i class="bi bi-caret-right-fill"></i>
            </button>
            <span>
                <p>Total: </p>
                <p><?php echo $order['total_cost'] ?>€</p>
            </span>
        </footer>
    </div>
    <div class="shipping card">
        <header>
            <button class="btn-specular">
                <i class="bi bi-caret-left-fill"></i>
                <i class="bi bi-box-seam-fill"></i>
            </button>
            <span>
                <h4><?php echo $order['tracking_number'] ?></h4>
                <p><?php echo $order['courier'] ?></p>
                <p><?php echo $order['shipment_cost'] ?> €</p>
            </span>
            <i class="bi bi-truck"></i>
        </header>
        <div class="tracking">
            <p><?php echo $order['shipment_date'] ?></p>
            <div class="progress-bar">
                <div class="bar">
                    <div class="progress">
                        <div class="dot"></div>
                        <p><?php echo $order['shipment_status'] ?></p>
                    </div>
                </div>
            </div>
            <p><?php echo $order['delivery_date'] ?></p>
        </div>
        <footer>
            <div class="toggle">
                <span>
                    <p>Note:</p>
                    <i class="bi bi-caret-down-fill"></i>
                </span>
                <p><?php echo $order['notes'] ?></p>
            </div>
            <div class="toggle">
                <span>
                    <p>To: (<?php echo $order['address_name'] ?>)</p>
                    <i class="bi bi-caret-down-fill"></i>
                </span>
                <p><?php echo $order['address_street_number'] . ' - ' . $order['address_city'] . ' (' . $order['address_postal_code'] . ')' ?></p>
            </div>
        </footer>
    </div>
</div>