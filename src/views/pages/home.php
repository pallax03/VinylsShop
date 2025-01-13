<section class="no-margin no-padding">
    <h2 class="home-title">Welcome to VinylsShop</h2>
    <div class="carousel">
        <?php foreach ($data['vinyls'] as $vinyl): ?>
            <a href="/vinyl?id=<?php echo $vinyl['id_vinyl']?>">
                <img src="/resources/img/albums/<?php echo $vinyl['cover'] ?>"/>
                <span>
                    <p> <?php echo $vinyl['title'] ?></p>
                    <p> <?php echo $vinyl['artist'] ?> </p>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<section>
    
</section>
<script src="/resources/js/home.js"></script>