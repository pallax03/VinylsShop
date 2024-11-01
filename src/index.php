<?php
    require_once './DatabaseUtility.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>server</title>
        <link rel="stylesheet" href="/css/style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
    </head>
    <body>
        <?php
            $var = "database: " . (DatabaseUtility::connect() ? 'connected' : 'not connected');
            include_once './components/header.php';
        ?>
        
        <main>
            <h1>Home</h1>
        </main>
        
        
        <?php
            include_once './components/footer.php';
        ?>
    </body>
</html>