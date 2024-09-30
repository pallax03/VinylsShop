<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>server</title>

        <link rel="stylesheet" href="./css/layouts.css">
    </head>
    <body>
        <?php
            $var = 'Questo è un header!';
            include_once './layouts/header.php';
        ?>
        
        <section>
            <h1>xampp is working</h1>
        </section>
        
        
        <?php
            include_once './layouts/footer.php';
        ?>
    </body>
</html>