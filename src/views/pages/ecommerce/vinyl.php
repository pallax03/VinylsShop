<section class="album-details">
    <img class="album-cover" src="/resources/img/albums/<?php echo $data["vinyl"]["details"]["cover"]?>" alt=""/>
    <h1 class="album-title"><?php echo $data["vinyl"]["details"]["title"] ?></h1>
    <p class="info">
        <?php
            $details = $data["vinyl"]["details"];
            echo $details["rpm"] . " - " . $details["inch"]
                . " - " . $details["type"];
        ?>
    </p>
    <div class="large button">
        <i class="bi bi-bag-fill"></i>
        <button onclick="addToCart(<?php echo $data['vinyl']['details']['id_vinyl'] ?>, 1)">
            <?php echo $data['vinyl']['details']['stock'] <= 0 ? 'Out of stock' : 'Add to cart - ' . $data["vinyl"]["details"]["cost"] . ' €' ?>
        </button>
    </div>
    
</section>
<div class="div"></div>
<section class="tracklist">
    <h1>Album Info</h1>
    <div class="artist-info">
        <b><?php echo $data["vinyl"]["details"]["artist"] ?></b>
        <b><?php echo $data["vinyl"]["details"]["release_date"] ?></b>
        <b><?php echo $data["vinyl"]["details"]["genre"] ?></b>
    </div>
    <ol class="album">
        <?php
            foreach ($data["vinyl"]["tracks"] as $track):
                echo(
                    '<li class="track">
                        <span class="track-info">
                            <p>' . $track["title"] . '</p>
                            <p>' . $track["duration"] . '</p>
                        </span>
                    </li>'
                );
            endforeach;
        ?>
    </ol>
    <div class="div"></div>
</section>
<section class="no-margin no-padding">
    <h2>Recommended</h2>
    <div class="recommended">
        <div>
            <?php foreach ($data["suggested"] as $vinyl): ?>
                <a href="/vinyl?id=<?php echo $vinyl['id_vinyl']?>" aria-label="<?php echo $vinyl['title'] ?>">
                    <img src="/resources/img/albums/<?php echo $vinyl['cover'] ?>" alt=""/>
                    <span>
                        <p><?php echo $vinyl['title'] ?></p>
                        <p><?php echo $vinyl['artist_name'] ?></p>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>