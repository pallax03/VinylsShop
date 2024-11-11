<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" type="text/css" href="/resources/css/style.css? <?php echo date('l jS \of F Y h:i:s A'); ?>">
    <?php foreach ($style as $s) {
        echo '<link rel="stylesheet" type="text/css" href="/resources/css/' . $s . '.css?'. date('l jS \of F Y h:i:s A') . '">';
    } ?>
    <!-- <script   src="https://code.jquery.com/jquery-3.7.1.slim.min.js"   integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8="   crossorigin="anonymous"></script> -->
</head>
<body>
    <?php include COMPONENTS . '/header.php' ?>
    
    <?php include $page ?>
    
    <?php include COMPONENTS . '/footer.php' ?>
</body>
</html>