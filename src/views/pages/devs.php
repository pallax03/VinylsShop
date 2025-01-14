<section>
    <h1>Relazione</h1>
    <?php
        $file_path = ROOT . '/relazione.pdf';
        if (file_exists($file_path)) {
            echo '<embed src="/relazione.pdf" type="application/pdf" width="100%" height="1200px" />';
        } else {
            include PAGES . '/notfound.php';
        }
    ?>
</section>