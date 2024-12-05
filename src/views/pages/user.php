<main>
    <?php if(Session::isLogged()): ?>
    <h1>Welcome <?php echo $mail ?></h1> 
    <p>newsletter <?php echo $newsletter ? 'True' : False ;?></p>
    <a href="/logout">Logout</a>
    <?php else: ?>
        <?php include COMPONENTS . 'login.php'?>
    <?php endif; ?>
</main>
