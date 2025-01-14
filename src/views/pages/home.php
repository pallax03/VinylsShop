<section class="margin-top no-padding">
    <h2 class="home-title">Welcome to VinylsShop</h2>
    <div class="my-carousel" id="home-carousel_1">
        <?php for ($i=0; $i < 2; $i++): ?>
            <?php foreach ($data['vinyls'] as $vinyl): ?>
                <a class="my-slide" href="/vinyl?id=<?php echo $vinyl['id_vinyl']?>">
                    <img src="/resources/img/albums/<?php echo $vinyl['cover'] ?>"/>
                    <span>
                        <p> <?php echo $vinyl['title'] ?></p>
                        <p> <?php echo $vinyl['artist'] ?> </p>
                    </span>
                </a>
            <?php endforeach; ?>
        <?php endfor; ?>
    </div>
    <div class="my-carousel" id="home-carousel_2">
        <?php for ($i=0; $i < 2; $i++): ?>
            <?php foreach ($data['vinyls'] as $vinyl): ?>
                <a class="my-slide" href="/vinyl?id=<?php echo $vinyl['id_vinyl']?>">
                    <img src="/resources/img/albums/<?php echo $vinyl['cover'] ?>"/>
                    <span>
                        <p> <?php echo $vinyl['title'] ?></p>
                        <p> <?php echo $vinyl['artist'] ?> </p>
                    </span>
                </a>
            <?php endforeach; ?>
        <?php endfor; ?>
    </div>
    <div class="my-carousel" id="home-carousel_3">
        <?php for ($i=0; $i < 2; $i++): ?>
            <?php foreach ($data['vinyls'] as $vinyl): ?>
                <a class="my-slide" href="/vinyl?id=<?php echo $vinyl['id_vinyl']?>">
                    <img src="/resources/img/albums/<?php echo $vinyl['cover'] ?>"/>
                    <span>
                        <p> <?php echo $vinyl['title'] ?></p>
                        <p> <?php echo $vinyl['artist'] ?> </p>
                    </span>
                </a>
            <?php endforeach; ?>
        <?php endfor; ?>
    </div>
</section>

<section>
    
</section>
<script src="/resources/js/home.js"></script>