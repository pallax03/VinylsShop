<section class="vinyl-details">
    <img class="vinyl-details" title=<?php echo $data["vinyl"]["details"]["title"] ?> src="/resources/img/albums/<?php echo $data["vinyl"]["details"]["cover"]?>"/>
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
    <h1 class="vinyl-title"><?php echo $data["vinyl"]["details"]["title"] ?></h1>
</section>