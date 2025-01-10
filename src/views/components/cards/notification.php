<?php  ?>
<div class="notification card <?php echo !filter_var($notification['is_read'], FILTER_VALIDATE_BOOL) ? 'unread' : ''; ?>" <?php echo !filter_var($notification['is_read'], FILTER_VALIDATE_BOOL) ? 'onfocus="readNotification('. $notification['id_notification'].')" onmouseover="readNotification('. $notification['id_notification'].')"' : ''?> id="card-notification_<?php echo $notification['id_notification']?>">
    <div class="close">
        <button onclick="deleteNotification(<?php echo $notification['id_notification']?>)">
            <i class="bi bi-x-circle-fill"></i>
        </button>
    </div>
    <header>
        <h4>
            <?php echo $notification['id_notification']?>
        </h4>
    </header>
    <div class="content">
        <span class="details">
            <i class="bi bi-info-circle"></i>
            <p>
                <?php echo $notification['message']?>
            </p>
        </span>
        <span class="time">
                <i class="bi bi-clock"></i>
                <p><?php echo $notification['created_at']?></p>
        </span>
    </div>
    <footer>
        <a href="<?php echo $notification['link'] ?>">
            <i class="bi bi-chevron-double-right"></i>
        </a>
    </footer>
</div>