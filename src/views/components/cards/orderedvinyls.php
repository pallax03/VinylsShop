<div class="card cart">
    <header>
        <div class="container">
            <p><? echo $vinyl['quantity']?></p>
            <i class="bi bi-x"></i>
        </div>
    </header>
    <div class="product-details">
        <div>
            <img src="/resources/img/albums/<? echo $vinyl['cover']?>" alt="album cover">
        </div>
        <div class="container vertical">
            <h2><?php echo $vinyl['title'];?></h2>
            <p><?php echo $vinyl['artist_name'];?> - <?php echo $vinyl['genre'];?></p>
            <p><?php echo $vinyl['type'];?> - <?php echo $vinyl['rpm'];?>rpm - <?php echo $vinyl['inch'];?>"</p>
        </div>
    </div>
    <footer>
        <p><?php echo $vinyl['cost'];?>€</p>
    </footer>
</div>