<div class="card cart">
    <header>
        <p>
            <?php echo $vinyl['quantity'];?>
        </p>
    </header>
    <div class="product-details">
        <div>
            <img src="/resources/img/albums/<? echo $vinyl['cover']?>" alt="album cover">
        </div>
        <div class="info">
            <h2><?php echo $vinyl['title'];?></h2>
            <p><?php echo $vinyl['artist_name'];?> - <?php echo $vinyl['genre'];?></p>
            <p><?php echo $vinyl['type'];?> - <?php echo $vinyl['rpm'];?>rpm - <?php echo $vinyl['inch'];?>"</p>
        </div>
    </div>
    <footer>
        <p><?php echo $vinyl['price'];?>€</p>
    </footer>
</div>