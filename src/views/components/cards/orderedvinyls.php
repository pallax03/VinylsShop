<div class="card cart">
    <header>
        <div class="container">
            <p><? echo $vinyl['quantity']?></p>
            <i class="bi bi-x"></i>
        </div>
    </header>
    <a href="/vinyl?id=<?php echo $vinyl['id_vinyl']?>" class="product-details">
        <div>
            <img src="/resources/img/albums/<? echo $vinyl['cover']?>" alt="album cover">
        </div>
        <div class="container vertical center">
            <h2><?php echo $vinyl['title'];?></h2>
            <p><?php echo $vinyl['artist_name'];?></p>
            <p>#<?php echo $vinyl['genre'];?></p>
            <p><?php echo $vinyl['type'];?> - <?php echo $vinyl['rpm'];?>rpm - <?php echo $vinyl['inch'];?>"</p>
        </div>
    </a>
    <footer>
        <p><?php echo $vinyl['cost'];?>€</p>
    </footer>
</div>