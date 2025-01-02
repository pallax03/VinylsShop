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
    <a class="add-cart">Add to cart - cost €<?php echo $data["vinyl"]["details"]["cost"] ?></a>
</section>
<section class="tracklist">
    <h1 class="album-title"><?php echo $data["vinyl"]["details"]["title"] ?></h1>
    <span class="artist-info">
        <p><?php echo $data["vinyl"]["details"]["artist"] ?></p>
        <p><?php echo $data["vinyl"]["details"]["release_date"] ?></p>
        <p><?php echo $data["vinyl"]["details"]["genre"] ?></p>
    </span>
    <ol class="album">
        <?php
            foreach ($data["vinyl"]["tracks"] as $track):
                echo('<li class="track">
                        <span class="track-info">
                            <p>' . $track["title"] . '</p>
                            <p>' . $track["duration"] . '</p>
                        </span>
                    </li>');
            endforeach;
        ?>
    </ol>
    <div class="div"></div>
</section>
<section class="recommended">
        
</section>