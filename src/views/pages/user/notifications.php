<section>
    <i class="bi bi-bell"></i>
    <?php if (isset($notifications) && $notifications !== []): ?>
        <h2>Notifications</h2>
        <?php
            foreach ($notifications as $notification) {
                include COMPONENTS . '/cards/notification.php';
            }
        ?>
    <?php else: ?>
        <h2>No notifications found!</h2>
    <?php endif; ?>
</section>
<script src="/resources/js/notifications.js"></script>