<main>
    
    <?php 
    if(isset($_COOKIE['token'])) {
        echo 'Token found';
        echo '<h3>Welcome back, '.$_SESSION['User']['mail'].'</h3>';
        echo '<p> You are '. ($_SESSION['User']['su'] ? 'an admin' : 'a user') .'.</p>';
    } else {
        include COMPONENTS . 'login.php';
    }
    
    ?>
</main>
