<div class="my-carousel" id="home-carousel_"+$i>
    <?php for ($j=0; $j < 2; $j++): ?>
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