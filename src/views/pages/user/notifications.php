<section>
    <i class="bi bi-bell"></i>
    <?php if (isset($notifications) && $notifications !== []): ?>
        <h1>Notifications</h1>
        <?php
            foreach ($notifications as $notification) {
                include COMPONENTS . '/cards/notification.php';
            }
        ?>
    <? else: ?>
        <h1>No notifications found!</h1>
    <? endif; ?>
</section>
<script src="/resources/js/notifications.js"></script>