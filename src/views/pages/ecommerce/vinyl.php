<section class="album-details">
    <img class="album-cover" src="/resources/img/albums/<?php echo $data["vinyl"]["details"]["cover"]?>"/>
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
            <?php echo $data['vinyl']['details']['stock'] == 0 ? 'Out of stock' : 'Add to cart - ' . $data["vinyl"]["details"]["cost"] . ' €' ?>
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
<section class="recommended">
    <h1 class="header">Recommended<h1>
    <?php
        foreach ($data["suggested"] as $vinyl):
            echo(
                '<a class="recommended-preview" href="vinyl?id=' . $vinyl["id_vinyl"] . '">
                    <div>
                        <img class="cover" src="resources/img/albums/' . $vinyl["cover"] . '"/>
                        <p class="title">' . $vinyl["title"] . '</p>
                    </div>
                </a>'
            );
        endforeach;
    ?>
        
</section>