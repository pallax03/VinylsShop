<div class="card cart">
    <div class="close">
        <button onclick="addToCart(<?php echo $item['vinyl']['id_vinyl'];?>, -<?php echo $item['quantity']?>)">
            <i class="bi bi-x-circle-fill"></i>
        </button>
    </div>
    <header>
        <div class="controls" id="controls-vinyl_<?php echo $item['vinyl']['id_vinyl']; ?>">
            <button onclick="addToCart(<?php echo $item['vinyl']['id_vinyl'];?>, 1)">
                <i class="bi bi-caret-up-fill"></i>
            </button>
            <p id="quantity-vinyl_<?php echo $item['vinyl']['id_vinyl']; ?>"><?php echo $item['quantity']?></p>
            <button onclick="addToCart(<?php echo $item['vinyl']['id_vinyl'];?>, -1)">
                <i class="bi bi-caret-down-fill"></i>
            </button>
        </div>
    </header>
    <a href="/vinyl?id=<?php echo $item['vinyl']['id_vinyl'] ?>" class="product-details">
        <div>
        <img src="/resources/img/albums/<?php echo $item['vinyl']['cover']?>" alt="album cover">
        </div>
        <div class="info">
            <p><?php echo $item['vinyl']['title']; ?></p>
            <p><?php echo $item['vinyl']['artist_name'] ?> #<?php echo $item['vinyl']['genre'] ?></p>
            <p><?php echo $item['vinyl']['type'] ?> - <?php echo $item['vinyl']['rpm'] ?>rpm - <?php echo $item['vinyl']['inch'] ?>"</p>
        </div>
    </a>
    <footer>
        <p><?php echo $item['vinyl']['cost']?> €</p>
    </footer>
</div>