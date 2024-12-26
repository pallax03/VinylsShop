<div class="flip">
    <div class="order card active">
        <header>
            <span>01</span>
            <a href="">
                <i class="bi bi-box-seam-fill"></i>
                <h2><? echo $order['order_status']?></h2>
            </a>
        </header>
        <div class="order-details">
            <ul>
                <?php foreach ($order['vinyls'] as $vinyl): ?>
                    <li>
                        <img src="<? echo $vinyl['album_cover']?>" alt="album cover">
                        <h6><? echo $vinyl['album_title']?></h6>
                        <p><? echo $vinyl['price']?> €</p>
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
                <p><?php echo $order['price'] ?>€</p>
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
                    <p>To: (address_name)</p>
                    <i class="bi bi-caret-down-fill"></i>
                </span>
                <p><?php echo $order['shipment_address'] ?></p>
            </div>
        </footer>
    </div>
</div>