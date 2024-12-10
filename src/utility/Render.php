<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="/resources/css/style.css? <?php echo date('l jS \of F Y h:i:s A'); ?>">
    <?php foreach ($style as $s) {
        // echo '<link rel="stylesheet" type="text/css" href="/resources/css/' . $s . '.css?'. date('l jS \of F Y h:i:s A') . '">';
    } ?>
    <script src="/resources/js/init.js"></script>

    <!-- <script   src="https://code.jquery.com/jquery-3.7.1.slim.min.js"   integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8="   crossorigin="anonymous"></script> -->
</head>
<body>
    <!-- <script src="/resources/js/main.js"></script> -->
    <?php include COMPONENTS . '/header.php' ?>
    
    <?php include COMPONENTS . '/nav.php' ?>

    <main id="main-content" aria-hidden="false">
        <?php include $page ?>
    </main>

    <section id="search-results" aria-hidden="true" hidden>
    </section>
    
    <?php include COMPONENTS . '/footer.php' ?>

    <script src="/resources/js/main.js"></script>
    <script src="/resources/js/search.js"></script>
</body>
</html>