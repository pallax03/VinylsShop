<h2 class="home-title">Welcome to VinylShop</h2>
<div class="carousel">
    <div>
        <?php foreach ($data['vinyls'] as $vinyl):
            echo('<a href="/vinyl?id=' . $vinyl['id_vinyl'] . '">
                    <img src="/resources/img/albums/' . $vinyl['cover'] . '"/>
                    <span>
                        <p>' . $vinyl['title'] . '</p>
                        <p>' . $vinyl['artist'] . '</p>
                    </span>
                </a>'
            );
        endforeach ?>
    </div>
</div>

<script src="/resources/js/home.js"></script>