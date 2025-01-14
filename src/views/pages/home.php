<section class="margin-top no-padding">
    <h2 class="home-title">Welcome to VinylsShop</h2>
    <div class="my-carousel" id="home-carousel_1">
        <?php for ($i=0; $i < 2; $i++): ?>
            <?php foreach ($data['vinyls'] as $vinyl): ?>
                <a class="my-slide" href="/vinyl?id=<?php echo $vinyl['id_vinyl']?>" aria-label="<?php echo $vinyl['title']?>">
                    <img src="/resources/img/albums/<?php echo $vinyl['cover'] ?>" alt=""/>
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
                <a class="my-slide" href="/vinyl?id=<?php echo $vinyl['id_vinyl']?>" aria-label="<?php echo $vinyl['title']?>">
                    <img src="/resources/img/albums/<?php echo $vinyl['cover'] ?>" alt=""/>
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
                <a class="my-slide" href="/vinyl?id=<?php echo $vinyl['id_vinyl']?>" aria-label="<?php echo $vinyl['title']?>">
                    <img src="/resources/img/albums/<?php echo $vinyl['cover'] ?>" alt=""/>
                    <span>
                        <p> <?php echo $vinyl['title'] ?></p>
                        <p> <?php echo $vinyl['artist'] ?> </p>
                    </span>
                </a>
            <?php endforeach; ?>
        <?php endfor; ?>
    </div>
</section>
<article class="home-article">
    <h2>Why buy on VinylsShop?</h2>
    <p>We are the best option of vinyl e-commerce</p>
    <div>
        <section>
            <div>
                <i class="bi bi-lightning-charge-fill"></i>
                <h3>Fast shipping</h3>
            </div>
            <p>Your orders are handled by Amazon, which means you'll receive your vinyl records quickly.</p>
        </section>
        <section>
            <div>
                <i class="bi bi-megaphone-fill"></i>
                <h3>Great prices</h3>
            </div>
            <p>Take advantage of great prices on vinyl and all other products available for purchase.</p>
        </section>
        <section>
            <div>
                <i class="bi bi-shield-shaded"></i>
                <h3>Safe payments</h3>
            </div>
            <p>Pay safely using our checkout: you can pay with major credit cards or using your profile balance.</p>
        </section>
    </div>
</article>

<script src="/resources/js/home.js"></script>